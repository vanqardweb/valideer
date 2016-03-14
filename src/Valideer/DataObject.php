<?php
namespace Vanqard\Valideer;

/**
 * Class DataObject
 * @package Vanqard\Valideer
 * @copyright 2016 Thunder Raven-Stoker
 * @license see LICENSE.md
 */
class DataObject implements \ArrayAccess, \Iterator
{
    /**
     * @var array
     */
    private $originalData;
    /**
     * @var array
     */
    private $fields = [];
    /**
     * @var array
     */
    private $keys = [];
    /**
     * @var int
     */
    private $position = 0;

    /**
     * Static factory method
     *
     * @param array $data
     * @return DataObject
     */
    public static function create(array $data = [])
    {
        return new self($data);
    }

    /**
     * DataObject constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->originalData = $data;
        $this->init();

    }

    /**
     * Initialisation method - called via constructor
     *
     * Sets up the internal keys array whilst also building the
     * DataField collection object
     */
    private function init()
    {
        foreach ($this->originalData as $key => $value) {
            $field = new DataField($key, $value, ['errors' => []]);

            $this->fields[$field->getName()] = $field;
        }

        $this->keys = array_keys($this->originalData);
    }


    /**
     * Adds an error to the supplied field object
     *
     * @param string $fieldName
     * @param string $errorMessage
     * @return DataObject $this
     */
    public function addError($fieldName, $errorMessage)
    {
        if (!is_array($errorMessage)) {
            $errorMessage = [$errorMessage];
        }

        if (!array_key_exists($fieldName, $this->fields)) {
            throw new ValidatorException(sprintf("Cannot set an error on a non-existent field: %s", $fieldName));
        }

        $field = $this->fields[$fieldName];
        $field->setAttr(
            'errors',
            array_merge($field->getAttr('errors'), $errorMessage)
        );

        return $this;
    }

    /**
     * Collates and returns an array of generated error messages from the field collection
     *
     * @return array
     */
    public function getErrors()
    {
        $returnArray = [];
        foreach ($this->fields as $key => $field) {
            if (!empty($field->getAttr('errors'))) {
                $returnArray[$key] = $field->getAttr('errors');
            }
        }

        return $returnArray;
    }

    /**
     * Collects the errors attribute of an individual field
     *
     * @param string $fieldName
     * @return array
     */
    public function getError($fieldName)
    {
        if (!array_key_exists($fieldName, $this->fields)) {
            throw new ValidatorException(sprintf('Cannot return errors for non-existent field %s', $fieldName));
        }

        return $this->fields[$fieldName]['errors'];
    }


    /**
     * Retrieves an individual field instance by key
     *
     * @param string $key
     * @return bool|DataField $field
     */
    public function getField($key)
    {
        if (!array_key_exists($key, $this->fields)) {
            return false;
        }

        return $this->fields[$key];
    }

    /**
     * ArrayAccess
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->fields[$key]['value'] = $value;
    }

    /**
     * ArrayAccess
     *
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->fields[$key]->getValue();
    }

    /**
     * ArrayAccess
     *
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->fields);
    }

    /**
     * ArrayAccess
     *
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        if ($this->offsetExists($key)) {
            unset($this->fields[$key]);
        }
    }

    /**
     * Iterator compliant
     * @return mixed
     */
    public function current()
    {
        $key = $this->keys[$this->position];
        return $this->fields[$key];
    }

    /**
     *  Iterator compliant
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->fields);
    }

    /**
     *  Iterator compliant
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     *  Iterator compliant
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->keys[$this->position];
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->keys[$this->position]);
    }
}
