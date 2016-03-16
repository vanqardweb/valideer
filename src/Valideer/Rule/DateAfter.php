<?php
namespace Vanqard\Valideer\Rule;
use Vanqard\Valideer\DataField;

/**
 * Date validations
 *
 * Class Date
 * @package Vanqard\Valideer\Rule
 */
class Date extends AbstractRule
{
    /**
     * @var string
     */
    public static $errorMessage = "Not a valid date";

    /**
     * Core isValid method
     *
     * @param \Vanqard\Valideer\DataField $field
     * @param array $params
     * @return bool
     */
    public function isValid(DataField $field, array $params = [])
    {
        $fieldValue = $field->getValue();

        if (!$fieldValue instanceof \DateTime) {
            try {
                $fieldValue = new \DateTime($fieldValue);
            } catch (\Exception $e) {
                // not a valid date string
                return false;
            }
        }

        if (!array_key_exists('before', $params)) {
            return false;
        }

        $testValue = ($params['before'] instanceof \DateTime) ?: new \DateTime($params['before']);

        return ($testValue < $fieldValue);
    }
}
