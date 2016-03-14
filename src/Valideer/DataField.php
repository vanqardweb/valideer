<?php
namespace Vanqard\Valideer;

/**
 * Class DataField
 * @package Vanqard\Valideer
 * @copyright 2016 Thunder Raven-Stoker
 * @license see LICENSE.md
 */
class DataField
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var array
     */
    protected $attrs = [];

    /**
     * DataField constructor.
     * @param string $name
     * @param mixed $value
     * @param array $attrs
     */
    public function __construct($name, $value, array $attrs = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->attrs = $attrs;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $attrName
     * @param $attrValue
     * @return DataField
     */
    public function setAttr($attrName, $attrValue)
    {
        $this->attrs[$attrName] = $attrValue;
        return $this;
    }

    /**
     * Method to add an attr as an array element
     *
     * @param string $attrName
     * @param mixed $attrValue
     * @return DataField $this
     */
    public function addToAttr($attrName, $attrValue)
    {
        $this->attrs[$attrName][] = $attrValue;
        return $this;
    }

    /**
     * @param string $attrName
     * @param null|mixed $default
     * @return null|mixed
     */
    public function getAttr($attrName, $default = null)
    {
        $returnValue = $default;
        if (array_key_exists($attrName, $this->attrs)) {
            $returnValue = $this->attrs[$attrName];
        }

        return $returnValue;
    }

    /**
     * Getter for the complete attributes array
     *
     * @return array
     */
    public function getAttrs()
    {
        return $this->attrs;
    }
}
