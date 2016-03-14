<?php
namespace Vanqard\Valideer\Rule;
use Vanqard\Valideer\DataField;

/**
 * Interface RuleInterface
 *
 * Core definition of the rule interface. Implementers only need to provide the
 * isValid method as indicated below in order to be compatible.
 *
 *
 * @package Vanqard\Valideer\Rule
 */
interface RuleInterface
{
    /**
     *
     * @important: Implementers must return a boolean value in order to conform to the interface.
     * Once support for PHP < 7.0 is ended, we can type hint for the return value as part of the method signature.
     *
     * @param $field
     * @param array $params
     * @return boolen
     */
    public function isValid(DataField $field, array $params = []);
}
