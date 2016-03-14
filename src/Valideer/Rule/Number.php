<?php
namespace Vanqard\Valideer\Rule;
use Vanqard\Valideer\DataField;

/**
 * Class Number
 * @package Vanqard\Valideer\Rule
 */
class Number extends AbstractRule
{
    /**
     * @var string
     */
    public static $errorMessage = "Number validation failed";

    /**
     * Core isValid method
     *
     * @param \Vanqard\Valideer\DataField $field
     * @param array $params
     * @return bool
     */
    public function isValid(DataField $field, array $params = [])
    {
        $returnValue = true;

        if (!is_numeric($field->getValue())) {
            $this->currentCustomErrorMessage = "Sorry. Wrong number.";
            $returnValue = false;
        }

        if (array_key_exists('min', $params)) {
            if ($field->getValue() < $params['min']) {
                $this->currentCustomErrorMessage = "Value is less than specified minimum {$params['min']}";
                $returnValue = false;
            }
        }

        if (array_key_exists('max', $params)) {
            if ($field->getValue() > $params['max']) {
                $this->currentCustomErrorMessage = "Value exceeds specified maximum {$params['max']}";
                $returnValue = false;
            }
        }

        return $returnValue;
    }
}
