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
        $result = false;

        $fieldValue = $field->getValue();

        if ($fieldValue instanceof \DateTime) {
            $result = true;
        } else if (is_string($fieldValue)) {
            try {
                $fieldValue = new \DateTime($fieldValue);
                $result = true;
            } catch (\Exception $e) {
                // Do nothing - result already false
            }
        }

        return $result;
    }
}
