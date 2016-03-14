<?php
namespace Vanqard\Valideer\Rule;
use Vanqard\Valideer\DataField;

/**
 * Email address validation
 *
 * Class Email
 * @package Vanqard\Valideer\Rule
 */
class Email extends AbstractRule
{

    /**
     * @var string
     */
    public static $errorMessage = "Not a valid email address";

    /**
     * Core isValid method
     *
     * @param \Vanqard\Valideer\DataField $field
     * @param array $params
     * @return boolean
     */
    public function isValid(DataField $field, array $params = [])
    {
        $result = filter_var($field->getValue(), FILTER_VALIDATE_EMAIL);

        return $result;
    }
}
