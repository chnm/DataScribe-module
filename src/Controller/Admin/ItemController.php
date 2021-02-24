<?php
namespace Datascribe\Controller\Admin;

use Datascribe\Form\DatasetExportForm;
use Datascribe\Form\DatasetSyncForm;
use Datascribe\Form\DatasetValidateForm;
use Datascribe\Form\ItemBatchForm;
use Datascribe\Form\ItemSearchForm;
use Omeka\Stdlib\Message;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ItemController extends AbstractActionController
{
    public function browseAction()
    {
        $dataset = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id')
        );
        if (!$dataset) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        // Sort by prioritized by default.
        $this->setBrowseDefaults('prioritized', 'desc');
        $query = array_merge(
            $this->params()->fromQuery(),
            ['datascribe_dataset_id' => $dataset->id()]
        );
        $response = $this->api()->search('datascribe_items', $query);
        $this->paginator($response->getTotalResults(), $this->params()->fromQuery('page'));
        $items = $response->getContent();

        if (!$dataset->itemSet()) {
            $message = new Message(
                'This dataset has no item set. %s', // @translate
                sprintf(
                    '<a href="%s">%s</a>',
                    htmlspecialchars($dataset->adminUrl('edit')),
                    $this->translate('Set an item set here.')
                ));
            $message->setEscapeHtml(false);
            $this->messenger()->addError($message);
        }

        $formSync = $this->getForm(DatasetSyncForm::class, ['dataset' => $dataset]);
        $formSync->setAttribute('action', $this->url()->fromRoute('admin/datascribe-dataset-id', ['action' => 'sync'], true));

        $formValidate = $this->getForm(DatasetValidateForm::class, ['dataset' => $dataset]);
        $formValidate->setAttribute('action', $this->url()->fromRoute('admin/datascribe-dataset-id', ['action' => 'validate'], true));

        $formExport = $this->getForm(DatasetExportForm::class, ['dataset' => $dataset]);
        $formExport->setAttribute('action', $this->url()->fromRoute('admin/datascribe-dataset-id', ['action' => 'export'], true));

        $view = new ViewModel;
        $view->setVariable('project', $dataset->project());
        $view->setVariable('dataset', $dataset);
        $view->setVariable('items', $items);
        $view->setVariable('formSync', $formSync);
        $view->setVariable('formValidate', $formValidate);
        $view->setVariable('formExport', $formExport);
        return $view;
    }

    public function showDetailsAction()
    {
        $item = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id'),
            $this->params('item-id')
        );
        if (!$item) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        $view = new ViewModel;
        $view->setTerminal(true);
        $dataset = $item->dataset();
        $view->setVariable('project', $dataset->project());
        $view->setVariable('dataset', $dataset);
        $view->setVariable('item', $item);
        $view->setVariable('oItem', $item->item());
        return $view;
    }

    public function searchAction()
    {
        $dataset = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id')
        );
        if (!$dataset) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        $form = $this->getForm(ItemSearchForm::class, ['dataset' => $dataset]);
        $form->setAttribute('method', 'get');
        $form->setAttribute('action', $this->url()->fromRoute(null, ['action' => 'browse'], true));
        $form->setData($this->params()->fromQuery());

        $view = new ViewModel;
        $project = $dataset->project();
        $view->setVariable('project', $project);
        $view->setVariable('dataset', $dataset);
        $view->setVariable('form', $form);
        $view->setVariable('query', $this->params()->fromQuery());
        return $view;
    }

    public function batchEditAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute(null, ['action' => 'browse'], true);
        }

        $dataset = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id')
        );
        if (!$dataset) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        $itemIds = $this->params()->fromPost('item_ids', []);

        $items = [];
        foreach ($itemIds as $itemId) {
            $items[] = $this->api()->read('datascribe_items', $itemId)->getContent();
        }

        $project = $dataset->project();
        $form = $this->getForm(ItemBatchForm::class, ['project' => $project]);

        if ($this->params()->fromPost('batch_edit')) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $formData = $form->getData();
                $this->api($form)->batchUpdate('datascribe_items', $itemIds, $formData);
                $this->messenger()->addSuccess('Items successfully edited.'); // @translate
                return $this->redirect()->toRoute(null, ['action' => 'browse'], true);
            } else {
                $this->messenger()->addFormErrors($form);
            }
        }

        $view = new ViewModel;
        $view->setVariable('project', $project);
        $view->setVariable('dataset', $dataset);
        $view->setVariable('items', $items);
        $view->setVariable('form', $form);
        return $view;
    }

    public function batchEditAllAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute(null, ['action' => 'browse'], true);
        }

        $dataset = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id')
        );
        if (!$dataset) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        $query = json_decode($this->params()->fromPost('query', []), true);
        $query['datascribe_dataset_id'] = $dataset->id();
        unset(
            $query['submit'], $query['page'], $query['per_page'],
            $query['limit'], $query['offset'], $query['sort_by'],
            $query['sort_order']
        );
        $count = $this->api()->search('datascribe_items', array_merge($query, ['limit' => 0]))->getTotalResults();

        $project = $dataset->project();
        $form = $this->getForm(ItemBatchForm::class, ['project' => $project]);

        if ($this->params()->fromPost('batch_edit')) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $formData = $form->getData();
                $job = $this->jobDispatcher()->dispatch('Omeka\Job\BatchUpdate', [
                    'resource' => 'datascribe_items',
                    'query' => $query,
                    'data' => $formData,
                ]);
                $this->messenger()->addSuccess('Editing items. This may take a while.'); // @translate
                return $this->redirect()->toRoute(null, ['action' => 'browse'], true);
            } else {
                $this->messenger()->addFormErrors($form);
            }
        }

        $view = new ViewModel;
        $view->setVariable('project', $project);
        $view->setVariable('dataset', $dataset);
        $view->setVariable('count', $count);
        $view->setVariable('query', $query);
        $view->setVariable('form', $form);
        return $view;
    }

    public function showAction()
    {
        return $this->redirect()->toRoute('admin/datascribe-record', ['action' => 'browse'], true);
    }
}
