<?php
namespace Datascribe\Form\Element;

use Laminas\Form\Element\Select as LaminasSelect;
use Laminas\InputFilter\InputProviderInterface;
use Laminas\Validator;

class Select extends LaminasSelect implements InputProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $fieldData = $this->getOption('datascribe_field_data');

        $this->setEmptyOption('');
        $this->setValueOptions(array_combine($fieldData['options'], $fieldData['options']));

        $attributes = [];
        $this->setAttributes(array_filter($attributes));
    }

    public function getValidators()
    {
        $fieldData = $this->getOption('datascribe_field_data');

        $validators = [];

        $haystack = array_merge(['' => ''], $fieldData['options']);
        $validators[] = new Validator\InArray(['haystack' => $haystack]);

        return $validators;
    }

    public function getInputSpecification()
    {
        return [
            'name' => $this->getName(),
            'required' => false,
            'allow_empty' => true,
            'validators' => $this->getValidators(),
            'filters' => [],
        ];
    }
}
