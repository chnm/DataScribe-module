<?php
namespace Datascribe\Api\Representation;

use Datascribe\Entity\DatascribeValue;
use Omeka\Api\Representation\AbstractRepresentation;
use Laminas\ServiceManager\ServiceLocatorInterface;

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

    public function text()
    {
        return $this->value->getText();
    }

    public function textIsValid()
    {
        $text = $this->text();
        $field = $this->field();
        if (null === $text) {
            // Null text is invalid if the field is required and the value is
            // not missing and not illegible.
            return !($field->isRequired() && !$this->isMissing() && !$this->isIllegible());
        }
        return $field->dataTypeService()->valueTextIsValid($field->data(), $text);
    }

    /**
     * Return this value's text formatted for display.
     *
     * The options are:
     * - length: the maximum length of the text (default is null)
     * - trim_marker: a string that follows text that exceeds the maximum length (defualt is null)
     * - if_unknown_return: return this if the text is unknown (default is false)
     * - if_invalid_return: return this if the text is invalid (default is false)
     * - if_null_return: return this if the text is null (default is null)
     * - if_empty_return: return this if the text is empty (default is an empty string)
     *
     * @param array $options
     * @return mixed
     */
    public function displayText(array $options = [])
    {
        // Set default options.
        $options['length'] = $options['length'] ?? null;
        $options['trim_marker'] = $options['trim_marker'] ?? null;
        $options['if_unknown_return'] = $options['if_unknown_return'] ?? false;
        $options['if_invalid_return'] = $options['if_invalid_return'] ?? false;
        $options['if_null_return'] = $options['if_null_return'] ?? null;
        $options['if_empty_return'] = $options['if_empty_return'] ?? '';

        if ($this->field()->dataTypeIsUnknown()) {
            return $options['if_unknown_return'];
        }
        if (!$this->textIsValid()) {
            return $options['if_invalid_return'];
        }
        if (null === $this->text()) {
            return $options['if_null_return'];
        }
        $text = $this->text();
        $textLength = mb_strlen($text);
        if (0 === $textLength) {
            return $options['if_empty_return'];
        }
        if ($options['length']) {
            $text = mb_substr($text, 0, (int) $options['length']);
        }
        if ($options['trim_marker'] && $textLength > mb_strlen($text)) {
            $text .= $options['trim_marker'];
        }
        return $text;
    }
}
