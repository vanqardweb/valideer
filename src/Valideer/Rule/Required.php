<?php
namespace Vanqard\Valideer\Rule;
use Vanqard\Valideer\DataField;

/**
 * Class Required
 * @package Vanqard\Valideer\Rule
 */
class Required extends AbstractRule
{
    /**
     * @var string
     */
    public static $errorMessage = "Required field";

    /**
     * Core isValid method
     *
     * @param \Vanqard\Valideer\DataField $field
     * @param array $params
     * @return bool
     */
    public function isValid(DataField $field, array $params = [])
    {
        if (empty($field->getValue())) {
            return false;
        }

        return true;
    }
}
