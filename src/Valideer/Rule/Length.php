<?php
namespace Vanqard\Valideer\Rule;
use Vanqard\Valideer\DataField;

/**
 * Class Length
 * @package Vanqard\Valideer\Rule
 */
class Length extends AbstractRule
{
    /**
     * @var string
     */
    public static $errorMessage = "Not a valid string length";

    /**
     * Core isValid method
     *
     * @param \Vanqard\Valideer\DataField $field
     * @param array $params
     * @return bool
     */
    public function isValid(DataField $field, array $params = [])
    {
        $length = strlen($field->getValue());

        $returnValue = true;

        if (array_key_exists('min', $params) && (int)$params['min'] > $length) {
            self::$errorMessage = "Length is less than specified minimum {$params['min']}";
            $returnValue = false;
        }

        if (array_key_exists('max', $params) && (int)$params['max'] < $length) {
            self::$errorMessage = "Length exceeds specified maximum {$params['length']}";
            $returnValue = false;
        }

        return $returnValue;
    }
}
