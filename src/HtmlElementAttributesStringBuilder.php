<?php

namespace Fewbricks;

class HtmlElementAttributesStringBuilder
{

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $valuesSeparators;

    /**
     * @var
     */
    protected $quoteCharacter;

    /**
     * HtmlElementAttributesManager constructor.
     */
    public function __construct()
    {

        $this->attributes       = [];
        $this->valuesSeparators = [];
        $this->quoteCharacter   = '"';

    }

    /**
     * @return string
     */
    public function __toString()
    {

        $string = '';

        foreach ($this->attributes AS $attributeName => $values) {

            $valuesString = '';

            $valueSeparator = $this->getValueSeparator($attributeName, 1);

            $lastValue = end($values);

            foreach ($values AS $value) {

                if (is_array($value)) {

                    $valuesString .= implode($this->getValueSeparator($attributeName, 2), $value);

                } else {

                    $valuesString .= $value;

                }

                if ($value !== $lastValue) {

                    $valuesString .= $valueSeparator;

                }

            }

            $string .= ' ' . $attributeName . '=' . $this->quoteCharacter . $valuesString . $this->quoteCharacter . ' ';

        }

        return trim($string);

    }

    /**
     * @param $attributeName
     *
     * @return string
     */
    public function getValueSeparator($attributeName, $level = 1)
    {

        $separator = null;

        if (isset($this->valuesSeparators[$attributeName])) {

            $separator = $this->getCustomSeparator($attributeName, $level);

        } else if ($attributeName === 'style') {

            $separator = $this->getSeparatorForStyle($level);

        } else {

            $separator = ' ';

        }

        if (is_null($separator)) {

            wp_die('HtmlElementAttributesManager could not find separator for attribute "' . $attributeName
                   . '" at level ' . $level);

        }

        return $separator;

    }

    /**
     * @param $level
     *
     * @return mixed
     */
    public function getSeparatorForStyle($level)
    {

        $separators = [
            1 => ';',
            2 => ':',
        ];

        return $separators[$level];

    }

    /**
     * @param string $name
     * @param array  $values
     */
    public function addValues($name, $values)
    {

        foreach ($values AS $value) {

            $this->addValue($name, $value);

        }

    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function addValue($name, $value)
    {

        if (!isset($this->attributes[$name])) {
            $this->attributes[$name] = [];
        }

        if (is_array($value)) {
            $key = (string)$value[0];
        } else {
            $key = (string)$value;
        }

        // Disables duplicate values and also makes it easy to find existing values
        $this->attributes[$name][$key] = $value;

    }

    /**
     * @return array
     */
    public function getAttributes()
    {

        return $this->attributes;

    }

    /**
     * @param $attributeName
     * @param $level
     *
     * @return array|mixed
     */
    public function getCustomAttributeSeparator($attributeName, $level)
    {

        $separators = $this->valuesSeparators[$attributeName];

        $levelIndex = ($level - 1);

        if (is_array($separators) && isset($separators[$level])) {

            $separator = $separators[$levelIndex];

        } else {

            $separator = $separators;

        }

        return $separator;

    }

    /**
     * If you want to remove a value like "color" for "style" which you set by passing an array ["color", "red"], you
     * must pass "color" as the value you want to remove.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function removeValue($name, $value)
    {

        if (isset($this->attributes[$name])) {

            unset($this->attributes[$name][(string)$value]);

        }

    }

    /**
     * @param $attributeName
     */
    public function resetAttribute($attributeName)
    {

        $this->attributes[$attributeName] = [];

    }

    /**
     * @param $character
     */
    public function setQuoteCharacter($character)
    {

        $this->quoteCharacter = $character;

    }

    /**
     * Use this function if you need to set custom separators between values of a certain attribute.
     * The class will add the correct ";" and ":" for "style" and use spaces for all other unless you tell it otherwise
     * here. But if you for example were to set the separators for "style", you would pass [':', ';'] and for the
     * attribute "class", you would pass " " or [" "]
     *
     * @param string       $attributeName
     * @param array|string $separators
     */
    public function setValuesSeparators($attributeName, $separators)
    {

        $this->valuesSeparators[$attributeName] = $separators;

    }

}
