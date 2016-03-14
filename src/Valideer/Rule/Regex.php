<?php
namespace Vanqard\Valideer\Rule;

use Vanqard\Valideer\DataField;
use Vanqard\Valideer\ValidatorException;

/**
 * Class Regex
 * @package Vanqard\Valideer\Rule
 */
class Regex extends AbstractRule
{
    /**
     * @var string
     */
    public static $errorMessage = "Value does not match supplied pattern";

    /**
     * Core isValid  method
     *
     * @param \Vanqard\Valideer\DataField $field
     * @param array $params
     * @return int
     */
    public function isValid(DataField $field, array $params = [])
    {

        if (!array_key_exists('regex', $params)) {
            throw new ValidatorException("Regex is a required regex rule parameter");
        }

        $pattern = $params['regex'];

        return preg_match($pattern, $field->getValue());
    }
}
