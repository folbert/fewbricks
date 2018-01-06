<?php

namespace Fewbricks;

class HtmlHelper
{

    /**
     * @param array  $attributes
     * @param string $quotationMark
     * @param string $secondaryLevelDividers   Either a string with a divider to be used for all attributes,
     *                                         or an array where the attribute name is the key and value is the divider
     *                                         like ['class' => ' ', 'style' => ';']. No need to tell the function that
     *                                         ";" should be used for "style" since it knows that.
     *
     * @return string
     */
    public static function associativeArrayToElementAttributesString(
        array $attributes,
        $secondaryLevelDividers = ' ',
        $quotationMark = '"'
    ) {

        $string = '';

        foreach ($attributes AS $attributeName => $attributeValue) {

            if (is_array($attributeValue)) {

                if (is_array($secondaryLevelDividers) && isset($secondaryLevelDividers[$attributeName])) {

                    if (isset($secondaryLevelDividers[$attributeName])) {
                        $divider = $secondaryLevelDividers[$attributeName];
                    } else {
                        $divider = ' '; // Fall back to something
                    }

                } else {

                    switch ($attributeName) {

                        case 'style' :
                            $divider = ';';
                            break;

                        case 'class' :
                            $divider = ' ';
                            break;

                        default :

                            $divider = $secondaryLevelDividers;

                    }

                }

                $attributeValueString = '';

                foreach ($attributeValue AS $attributeValueItem) {

                    $attributeValueString .= $attributeValueItem . $divider;

                }

                $attributeValue = trim($attributeValueString);

            }

            if ($attributeValue !== '') {
                $string .= $attributeName . '=' . $quotationMark . trim(str_replace('  ', ' ',
                        $attributeValue)) . $quotationMark . ' ';
            }

        }

        return trim($string);

    }

}
