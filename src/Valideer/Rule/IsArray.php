<?php
namespace Vanqard\Valideer\Rule;

use Vanqard\Valideer\DataField;

/**
 * Class IsArray
 * @package Vanqard\Valideer\Rule
 */
class IsArray extends AbstractRule
{
    /**
     * @var string
     */
    public static $errorMessage = "Array validation failed";

    /**
     * Core isValid method
     *
     * @param DataField $field
     * @param array $params
     * @return bool
     */
    public function isValid(DataField $field, array $params = [])
    {
        $fieldValue = $field->getValue();

        if (!is_array($fieldValue)) {
            return false;
        }
    }
}
