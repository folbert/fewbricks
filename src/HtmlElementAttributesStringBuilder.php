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
        $this->valuesSeparators = [
            'style' => [':', ';'],
        ];
        $this->quoteCharacter   = '"';

    }

    /**
     * @return string
     */
    public function __toString()
    {

        $string = '';

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

        $valuesForAttribute = $this->getValuesForAttribute($attributeName);

        $lastValue = end($valuesForAttribute);

        foreach ($valuesForAttribute AS $key => $value) {

            $valuesString .= $this->getValuesString($attributeName, $value);

            if ($value !== $lastValue) {
                $valuesString .= $this->getValueSeparator($attributeName, 1);
            }

        }

        return ' ' . $attributeName . '=' . $this->quoteCharacter . $valuesString . $this->quoteCharacter . ' ';

    }

    /**
     * @param string $attributeName
     *
     * @return array|string
     */
    public function getValuesForAttribute($attributeName)
    {

        $values = [];

        if (isset($this->attributes[$attributeName])) {

            $values = $this->attributes[$attributeName];

            if (!is_array($values)) {
                $values = [$values];
            }

        }

        return $values;

    }

    /**
     * @param string $attributeName
     * @param mixed  $value
     *
     * @return string
     */
    private function getValuesString($attributeName, $value)
    {

        if (is_array($value)) {

            $valuesString = '';
            $values       = array_values($value); // Make sure we are working with a numeric array

            foreach ($values AS $key => $value) {

                $valuesString .= $value;

                if ($key + 1 < (count($values))) {
                    $valuesString .= $this->getValueSeparator($attributeName, (count($value) - ($key + 1)));
                }

            }

        } else {

            $valuesString = $value;

        }

        return $valuesString;

    }

    /**
     * @param string $attributeName
     * @param int    $valuesLevel
     *
     * @return string
     */
    public function getValueSeparator($attributeName, $valuesLevel = 1)
    {

        if (isset($this->valuesSeparators[$attributeName])) {

            $separator = $this->getValuesSeparator($attributeName, $valuesLevel);

        } else if ($attributeName === 'style') {

            $separator = $this->getSeparatorForStyle($valuesLevel);

        } else {

            $separator = ' ';

        }

        return $separator;

    }

    /**
     * @param $attributeName
     * @param $valuesLevel
     *
     * @return string
     */
    public function getValuesSeparator($attributeName, $valuesLevel)
    {

        $separator = ' ';

        if (isset($this->valuesSeparators[$attributeName])
            && count($this->valuesSeparators[$attributeName]) >= $valuesLevel
        ) {

            $separator = array_slice($this->valuesSeparators[$attributeName], (0 - $valuesLevel), 1)[0];

        }

        return $separator;

    }

    /**
     * @param $className
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addClassName($className)
    {

        $this->addValueToAttribute($className, 'class');

        return $this;

    }

    /**
     *
     * @param string $value
     * @param string $attributeName
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addValueToAttribute($value, $attributeName)
    {

        if($attributeName === 'style') {
            $this->removeStyleProperty($value[0]);
        }

        if (!isset($this->attributes[$attributeName])) {
            $this->attributes[$attributeName] = [];
        }

        if (is_array($value)) {
            $key = md5(serialize($value));
        } else {
            $key = (string)$value;
        }

        // Disables duplicate values and also makes it easy to find existing values
        $this->attributes[$attributeName][$key] = $value;

        return $this;

    }

    /**
     * @param array $propertiesAndValues
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addStylePropertiesAndValues(array $propertiesAndValues)
    {

        foreach ($propertiesAndValues AS $propertyAndValue) {

            $this->addStylePropertyAndValue($propertyAndValue[0], $propertyAndValue[1]);

        }

        return $this;

    }

    /**
     * @param $property
     * @param $value
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addStylePropertyAndValue($property, $value)
    {

        $this->removeStyleProperty($property);
        $this->addValueToAttribute([$property, $value], 'style');

        return $this;

    }

    /**
     * @param array  $values
     * @param string $attributeName
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function addValuesToAttribute($values, $attributeName)
    {

        foreach ($values AS $value) {

            $this->addValueToAttribute($value, $attributeName);

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
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function removeClassName($className)
    {

        $this->removeValueFromAttribute($className, 'class');

        return $this;

    }

    /**
     * If you want to remove a value like "color" for "style" which you set by passing an array ["color", "red"], you
     * must pass "color" as the value you want to remove.
     *
     * @param mixed  $value
     * @param string $attributeName
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function removeValueFromAttribute($value, $attributeName)
    {

        if($attributeName === 'style') {
            die('Please use the function removeStyleProperty to remove a style property');
        }

        if (isset($this->attributes[$attributeName])) {

            if (is_array($value)) {

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
    public function removeStyleProperty($property)
    {

        $styleValues = $this->getValuesForAttribute('style');

        foreach($styleValues AS $key => $styleValue) {

            if($styleValue[0] === $property) {

                unset($this->attributes['style'][$key]);

            }

        }

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
     * @param array|string $separators
     * @param string       $attributeName
     *
     * @return HtmlElementAttributesStringBuilder
     */
    public function setValuesSeparatorsForAttribute($separators, $attributeName)
    {

        if (!is_array($separators)) {
            $separators = [$separators];
        }

        $this->valuesSeparators[$attributeName] = $separators;

        return $this;

    }

}
