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

        if (!empty($params) && $result) {
            foreach ($params as $test => $testParams) {
                switch ($test) {
                    case 'before':
                        if (!$this->dateIsBefore($fieldValue, [$test => $testParams])) {
                            $result = false;
                            break 2;
                        }
                        break;
                    case 'after':
                        if (!$this->dateIsAfter($fieldValue, [$test => $testParams])) {
                            $result = false;
                            break 2;
                        }
                        break;
                }
            }
        }

        return $result;
    }

    /**
     * Test to determine if field date value is before the given test value
     *
     * @param \DateTime $fieldValue
     * @param array $params
     * @return bool
     */
    private function dateIsBefore(\DateTime $fieldValue, array $params)
    {
        $testValue = ($params['before'] instanceof \DateTime) ? $params['before'] : new \DateTime($params['before']);
        return ($testValue > $fieldValue);
    }

    /**
     * Test to determine if field date value is after the given test value
     *
     * @param \DateTime $fieldValue
     * @param array $params
     * @return bool
     */
    private function dateIsAfter(\DateTime $fieldValue, array $params)
    {
        $testValue = ($params['after'] instanceof \DateTime) ? $params['before'] : new \DateTime($params['after']);
        return ($fieldValue > $testValue);
    }
}
