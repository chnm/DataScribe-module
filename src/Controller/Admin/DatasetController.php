<?php
namespace Datascribe\Controller\Admin;

use Datascribe\Form\DatasetForm;
use Datascribe\Form\DatasetSyncForm;
use Datascribe\Job\SyncDataset;
use Omeka\Form\ConfirmForm;
use Omeka\Stdlib\Message;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DatasetController extends AbstractActionController
{
    public function addAction()
    {
        $project = $this->datascribe()->getRepresentation($this->params('project-id'));
        if (!$project) {
            return $this->redirect()->toRoute('admin/datascribe');
        }
        $form = $this->getForm(DatasetForm::class);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $formData = $form->getData();
                $formData['o-module-datascribe:project']['o:id'] = $project->id();
                $formData['o:item_set'] = ['o:id' => $formData['o:item_set']];
                $formData['o:is_public'] = $this->params()->fromPost('o:is_public');
                $response = $this->api($form)->create('datascribe_datasets', $formData);
                if ($response) {
                    $this->messenger()->addSuccess('Dataset successfully created.'); // @translate
                    return $this->redirect()->toUrl($response->getContent()->url());
                }
            } else {
                $this->messenger()->addFormErrors($form);
            }
        }

        $view = new ViewModel;
        $view->setVariable('form', $form);
        $view->setVariable('project', $project);
        return $view;
    }

    public function editAction()
    {
        $dataset = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id')
        );
        if (!$dataset) {
            return $this->redirect()->toRoute('admin/datascribe');
        }
        $form = $this->getForm(DatasetForm::class, [
            'view_helper_manager' => $this->datascribe()->getViewHelperManager(),
            'data_type_manager' => $this->datascribe()->getDataTypeManager(),
            'dataset' => $dataset,
        ]);

        if ($this->getRequest()->isPost()) {
            $postData = $this->params()->fromPost();
            $form->setData($postData);
            if ($form->isValid()) {
                // Note that the form cannot validate new fields. Instead we
                // rely on browser and API validation.
                $postData['o:item_set'] = ['o:id' => $postData['o:item_set']];
                $response = $this->api($form)->update('datascribe_datasets', $this->params('dataset-id'), $postData);
                if ($response) {
                    $this->messenger()->addSuccess('Dataset successfully edited.'); // @translate
                    return $this->redirect()->toUrl($response->getContent()->url());
                }
            } else {
                $this->messenger()->addFormErrors($form);
            }
        } else {
            $data = $dataset->jsonSerialize();
            $data['o:item_set'] = $data['o:item_set'] ? $data['o:item_set']->id() : null;
            $form->setData($data);
        }

        $view = new ViewModel;
        $view->setVariable('form', $form);
        $view->setVariable('project', $dataset->project());
        $view->setVariable('dataset', $dataset);
        return $view;
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = $this->getForm(ConfirmForm::class);
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $response = $this->api($form)->delete('datascribe_datasets', $this->params('dataset-id'));
                if ($response) {
                    $this->messenger()->addSuccess('Dataset successfully deleted'); // @translate
                }
            } else {
                $this->messenger()->addFormErrors($form);
            }
        }
        return $this->redirect()->toRoute(null, ['action' => 'browse'], true);
    }

    public function browseAction()
    {
        $project = $this->datascribe()->getRepresentation($this->params('project-id'));
        if (!$project) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        $this->setBrowseDefaults('created');
        $query = array_merge(
            $this->params()->fromQuery(),
            ['datascribe_project_id' => $project->id()]
        );
        $response = $this->api()->search('datascribe_datasets', $query);
        $this->paginator($response->getTotalResults(), $this->params()->fromQuery('page'));
        $datasets = $response->getContent();

        $view = new ViewModel;
        $view->setVariable('project', $project);
        $view->setVariable('datasets', $datasets);
        return $view;
    }

    public function showDetailsAction()
    {
        $dataset = $this->datascribe()->getRepresentation(
            $this->params('project-id'),
            $this->params('dataset-id')
        );
        if (!$dataset) {
            return $this->redirect()->toRoute('admin/datascribe');
        }

        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setVariable('project', $dataset->project());
        $view->setVariable('dataset', $dataset);
        return $view;
    }

    public function showAction()
    {
        return $this->redirect()->toRoute('admin/datascribe-item', ['action' => 'browse'], true);
    }

    public function syncAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = $this->getForm(DatasetSyncForm::class);
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $job = $this->jobDispatcher()->dispatch(
                    SyncDataset::class,
                    ['datascribe_dataset_id' => $this->params('dataset-id')]
                );
                $this->messenger()->addSuccess('Syncing dataset. This may take a while.'); // @translate
                return $this->redirect()->toRoute('admin/datascribe-item', ['action' => 'browse'], true);
            }
        }
        return $this->redirect()->toRoute('admin/datascribe-dataset', ['action' => 'browse'], true);
    }
}
