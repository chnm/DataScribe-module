<?php
namespace Datascribe\Api\Representation;

use Datascribe\Entity\DatascribeValue;
use Omeka\Api\Representation\AbstractRepresentation;
use Zend\ServiceManager\ServiceLocatorInterface;

class DatascribeValueRepresentation extends AbstractRepresentation
{
    /**
     * @var DatascribeValue
     */
    protected $value;

    /**
     * @param DatascribeField $field
     * @param ServiceLocatorInterface $services
     */
    public function __construct(DatascribeValue $value, ServiceLocatorInterface $services)
    {
        $this->setServiceLocator($services);
        $this->value = $value;
    }

    public function jsonSerialize()
    {
    }

    public function id()
    {
        return $this->value->getId();
    }

    public function data()
    {
        return $this->value->getData();
    }

    public function field()
    {
        return new DatascribeFieldRepresentation(
            $this->value->getField(),
            $this->getServiceLocator()
        );
    }

    public function record()
    {
        return $this->getAdapter('datascribe_records')
            ->getRepresentation($this->value->getRecord());
    }

    public function isInvalid()
    {
        return $this->value->getIsInvalid();
    }

    public function isMissing()
    {
        return $this->value->getIsMissing();
    }

    public function isIllegible()
    {
        return $this->value->getIsIllegible();
    }

    public function valueIsValid()
    {
        $manager = $this->getServiceLocator()->get('Datascribe\DataTypeManager');
        $field = $this->field();
        $dataType = $manager->get($field->dataType());
        return $dataType->valueDataIsValid($field->data(), $this->data());
    }

    public function value(array $options = [])
    {
        // Set default options.
        $options['length'] = $options['length'] ?? null;
        $options['trim_marker'] = $options['trim_marker'] ?? null;
        $options['if_invalid_return'] = $options['if_invalid_return'] ?? false;
        $options['if_empty_return'] = $options['if_empty_return'] ?? null;

        if (!$this->valueIsValid()) {
            return $options['if_invalid_return'];
        }
        $manager = $this->getServiceLocator()->get('Datascribe\DataTypeManager');
        $dataType = $manager->get($this->field()->dataType());
        $value = $dataType->getValue($this->data());
        $valueLength = mb_strlen($value);
        if (0 === $valueLength) {
            return $options['if_empty_return'];
        }
        if ($options['length']) {
            $value = mb_substr($value, 0, (int) $options['length']);
        }
        if ($options['trim_marker'] && $valueLength > mb_strlen($value)) {
            $value .= $options['trim_marker'];
        }
        return $value;
    }
}