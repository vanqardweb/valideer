<?php
namespace Vanqard\Valideer;

use Vanqard\Valideer\Rule\RuleInterface;

/**
 * Class Validator
 * @package Vanqard\Valideer
 * @copyright 2016 Thunder Raven-Stoker
 * @license see LICENSE.md
 */
class Validator
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var bool
     */
    protected $isValid = true;

    /**
     * @var array|DataObject
     */
    protected $data = [];

    /**
     * Validator constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = new DataObject($data);
    }

    /**
     * Adds a rule instance to this validator's collection of rules
     *
     * @param $ruleName
     * @param $fieldName
     * @param array $params Optional rule parameters
     * @param null|string $errorMessage Optional custom error message
     * @return Validator $this  - fluent interface
     */
    public function addRule($ruleName, $fieldName, $params = [], $errorMessage = null)
    {

        if (!is_array($fieldName)) {
            $fieldName = [$fieldName];
        }

        $rule = $this->getRuleInstance($ruleName);

        foreach ($fieldName as $dataObjectKey) {
            $field = $this->data->getField($dataObjectKey);

            if (!$field) {
                throw new ValidatorException(sprintf("Cannot add a rule for a non-existent field: %s", $dataObjectKey));
            }

            $rule->addField($field, $params, $errorMessage);
        }

        return $this;
    }

    /**
     * Returns an instance of a Rule object based on the supplied rule name. This can either be the
     * short rule name such as 'date' or 'regex', or a fully qualified (with namespace) class name.
     *
     * @param $ruleName
     * @return AbstractRule
     */
    public function getRuleInstance($ruleName)
    {
        if (is_string($ruleName)) {
            $hasNamespace = (bool)(strpos($ruleName, '\\') !== false);

            if (!$hasNamespace) {
                $ruleName = '\Vanqard\Valideer\Rule\\' . ucwords($ruleName);
            }

            // Already instantiated?
            if (array_key_exists($ruleName, $this->rules)) {
                return $this->rules[$ruleName];
            }

            if (!class_exists($ruleName)) {
                throw new ValidatorException(sprintf("Rule %s could not be located", $ruleName));
            }

            $this->rules[$ruleName] = new $ruleName;

            return $this->rules[$ruleName];
        } else if ($ruleName instanceof RuleInterface ) {
            $rule = $ruleName;
            $ruleName = get_class($rule);

            if (!array_key_exists($ruleName, $this->rules)) {
                $this->rules[$ruleName] = $rule;
            }

            return $rule;
        }

        throw new ValidatorException("Add rule requires either a class name or a rule instance");
    }

    /**
     * Triggers the validation process and returns a boolean result indicating success or failure.
     *
     * @return bool
     */
    public function isValid()
    {
        $this->isValid = true;

        foreach ($this->rules as $rule) {
            $rule->validate();
        }

        return (empty($this->data->getErrors()));
    }

    /**
     * Collates and returns any error messages
     *
     * @return array
     */
    public function getErrors()
    {
        $returnArray = [];

        foreach ($this->data as $field) {
            $errors = $field->getAttr('errors');

            if (!empty($errors)) {
                $returnArray[$field->getName()] = $errors;
            }
        }

        return $returnArray;
    }

    /**
     * @param array|DataObject $data
     * @return Validator $this - fluent interface
     */
    public function setData($data)
    {
        if (is_array($data)) {
            $this->data = new DataObject($data);
        } else if ($data instanceof DataObject) {
            $this->data = $data;
        } else {
            throw new ValidatorException("Data parameter must be an array or an instance of DataObject");
        }

        return $this;
    }

    /**
     * Getter for the data object held by this validator
     *
     * @return DataObject
     */
    public function getData()
    {
        return $this->data;
    }
}
