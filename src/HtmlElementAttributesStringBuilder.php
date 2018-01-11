<?php

namespace Fewbricks;

/**
 * Class HtmlElementAttributesStringBuilder
 *
 * @package Fewbricks
 */
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
     * @var string
     */
    protected $quoteCharacter;

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

        dump($this->attributes);

        foreach ($this->attributes AS $attributeName => $values) {

            $string .= $this->getAttributeString($attributeName);

        }

        return trim($string);

    }

    /**
     * @param string $attributeName
     *
     * @return string
     */
    private function getAttributeString($attributeName)
    {

        $valuesString = '';

        $valuesForAttribute = $this->attributes[$attributeName];

        $valueSeparator = $this->getValueSeparator($attributeName, 1);

        $lastValue = end($valuesForAttribute);

        foreach ($valuesForAttribute AS $value) {

            $valuesString .= $this->getValueString($value, $attributeName);

            if ($value !== $lastValue) {
                $valuesString .= $valueSeparator;
            }

        }

        return ' ' . $attributeName . '=' . $this->quoteCharacter . $valuesString . $this->quoteCharacter . ' ';

    }

    /**
     * @param string $attributeName
     * @param int    $valuesLevel
     *
     * @return string
     */
    public function getValueSeparator($attributeName, $valuesLevel = 1)
    {

        $separator = null;

        if (isset($this->valuesSeparators[$attributeName])) {

            $separator = $this->getCustomSeparator($attributeName, $valuesLevel);

        } else if ($attributeName === 'style') {

            $separator = $this->getSeparatorForStyle($valuesLevel);

        } else {

            $separator = ' ';

        }

        if (is_null($separator)) {

            wp_die('HtmlElementAttributesManager could not find separator for attribute "' . $attributeName
                   . '" at level ' . $valuesLevel);

        }

        return $separator;

    }

    /**
     * @param $value
     * @param $attributeName
     *
     * @return string
     */
    private function getValueString($value, $attributeName)
    {

        if (is_array($value)) {

            $valueString = '';
            $values      = $value;
            $valueLevel  = 2;
            $lastValue   = end($values);

            foreach ($values AS $value) {

                $valueString .= $value;

                if ($value !== $lastValue) {
                    $valueString .= $this->getValueSeparator($attributeName, $valueLevel);
                    $valueLevel++;
                }

            }

        } else {

            $valueString = $value;

        }

        return $valueString;

    }

    /**
     * @param $attributeName
     * @param $valuesLevel
     *
     * @return string
     */
    public function getCustomSeparator($attributeName, $valuesLevel)
    {

        $separator = ' ';

        if (isset($this->valuesSeparators[$attributeName])
            && isset
            ($this->valuesSeparators[$attributeName][($valuesLevel - 1)])
        ) {

            $separator = ($this->valuesSeparators[$attributeName][($valuesLevel - 1)]);

        }

        return $separator;


    }

    /**
     * @param $valuesLevel
     *
     * @return mixed
     */
    public function getSeparatorForStyle($valuesLevel)
    {

        $separators = [
            1 => ';',
            2 => ':',
        ];

        return $separators[$valuesLevel];

    }

    /**
     * @param $className
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addClassName($className)
    {

        $this->addValue('class', $className);

        return $this;

    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addValue($name, $value)
    {

        if (!isset($this->attributes[$name])) {
            $this->attributes[$name] = [];
        }

        if (is_array($value)) {
            $key = md5(serialize($value));
        } else {
            $key = (string)$value;
        }

        // Disables duplicate values and also makes it easy to find existing values
        $this->attributes[$name][$key] = $value;

        return $this;

    }

    /**
     * @param array $propertiesAndValues
     */
    public function addStylePropertiesAndValues(array $propertiesAndValues)
    {

        foreach ($propertiesAndValues AS $propertyAndValue) {

            $this->addStylePropertyAndValue($propertyAndValue[0], $propertyAndValue[1]);

        }

    }

    /**
     * @param $property
     * @param $value
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addStylePropertyAndValue($property, $value)
    {

        $this->addValue('style', [$property, $value]);

        return $this;

    }

    /**
     * @param string $name
     * @param array  $values
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addValues($name, $values)
    {

        foreach ($values AS $value) {

            $this->addValue($name, $value);

        }

        return $this;

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
     * @param $valuesLevel
     *
     * @return array|mixed
     */
    public function getCustomAttributeSeparator($attributeName, $valuesLevel)
    {

        $separators = $this->valuesSeparators[$attributeName];

        $levelIndex = ($valuesLevel - 1);

        if (is_array($separators) && isset($separators[$valuesLevel])) {

            $separator = $separators[$levelIndex];

        } else {

            $separator = $separators;

        }

        return $separator;

    }

    /**
     * @param string $attributeName
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function removeAttribute($attributeName)
    {

        unset($this->attributes[$attributeName]);

        return $this;

    }

    /**
     * @param string $className
     */
    public function removeClassName($className)
    {

        $this->removeValue('class', $className);

    }

    /**
     * If you want to remove a value like "color" for "style" which you set by passing an array ["color", "red"], you
     * must pass "color" as the value you want to remove.
     *
     * @param string $attributeName
     * @param mixed  $value
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function removeValue($attributeName, $value)
    {

        if (isset($this->attributes[$attributeName])) {

            if(is_array($value)) {

                unset($this->attributes[$attributeName][md5(serialize($value))]);

            } else {

                unset($this->attributes[$attributeName][(string)$value]);

            }

        }

        return $this;

    }

    /**
     * @param string $property
     *
     * @return $this
     */
    public function removeStylePropertyAndValue($property)
    {

        $this->removeValue('style', $property);

        return $this;

    }

    /**
     * @param string $idValue
     *
     * @return $this
     */
    public function setIdValue($idValue)
    {

        $this->attributes['id'] = $idValue;

        return $this;

    }

    /**
     * Set the quote character to use in style="..." class="..."
     *
     * @param $character
     *
     * @return $this
     */
    public function setQuoteCharacter($character)
    {

        $this->quoteCharacter = $character;

        return $this;

    }

    /**
     * Use this function if you need to set custom separators between values of a certain attribute.
     * The class will add the correct ";" and ":" for "style" and use spaces for all other unless you tell it otherwise
     * here. But if you for example were to set the separators for "style", you would pass [':', ';'] and for the
     * attribute "class", you would pass " " or [" "]
     *
     * @param string       $attributeName
     * @param array|string $separators
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function setValuesSeparators($attributeName, $separators)
    {

        if (!is_array($separators)) {
            $separators = [$separators];
        }

        $this->valuesSeparators[$attributeName] = $separators;

        return $this;

    }

}
