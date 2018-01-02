<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldCollection;
use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithFields;
use Fewbricks\Helper;

/**
 * Class Repeater
 * Corresponds to the repeater field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Repeater extends FieldWithFields implements FieldInterface
{

    /**
     * @param $acfArray
     *
     * @return mixed
     */
    private function applyCollapsed($acfArray)
    {

        if ($this->getSetting('collapsed') !== false) {

            $newKey = Helper::getNewKeyByOriginalKeyInAcfArray($this->getSetting('collapsed'),
                $acfArray['sub_fields']);

            if ($newKey !== false) {
                $acfArray['collapsed'] = $newKey;
            }

        }

        return $acfArray;

    }

    /**
     * @param array $extraSettings Any extra settings that you want to apply at the last minute. Be careful not to set
     *                             crucial settings like "key" and "conditional_logic" here. We will not remove any
     *                             such items from the array in case you really want to set them,
     * case
     *
     * @return array|mixed
     */
    public function toAcfArray(array $extraSettings = [])
    {
        $acfArray = parent::toAcfArray($extraSettings);

        $acfArray = $this->applyCollapsed($acfArray);

        return $acfArray;

    }

    /**
     * @return mixed The value of the ACF setting "button_label". Returns the default ACF value of the translated
     * string of"Addrow" if none has been set using Fewbricks.
     */
    public function getButtonLabel()
    {

        return $this->getSetting('button_label', '');

    }

    /**
     * @return mixed The value of the ACF setting "collapsed". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getCollapsed()
    {

        return $this->getSetting('collapsed', '');

    }

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "table" if none has been
     * set using Fewbricks.
     */
    public function getLayout()
    {

        return $this->getSetting('layout', 'table');

    }

    /**
     * @return mixed The value of the ACF setting "m0". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMax()
    {

        return $this->getSetting('max', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getMin()
    {

        return $this->getSetting('min', 0);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'repeater';

    }

    /**
     * @param string $buttonLabel
     *
     * @return $this
     */
    public function setButtonLabel($buttonLabel)
    {

        $this->setSetting('button_label', $buttonLabel);

        return $this;

    }

    /**
     * Set a sub field to show when row is collapsed
     *
     * @param string $fieldKey
     *
     * @return $this
     */
    public function setCollapsed($fieldKey)
    {

        $this->setSetting('collapsed', $fieldKey);

        return $this;

    }

    /**
     * @param string $layout table, block or row
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        $this->setSetting('layout', $layout);

        return $this;

    }

    /**
     * Set maximum nr of rows
     *
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

        return $this;

    }

    /**
     * Set minimum nr of rows
     *
     * @param int $min
     *
     * @return $this
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

        return $this;

    }

}
