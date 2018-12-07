<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithFields;
use Fewbricks\Helpers\Helper;

/**
 * Class Repeater
 * Corresponds to the repeater field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Repeater extends FieldWithFields implements FieldInterface
{

    const TYPE = 'repeater';

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
     * @return mixed The value of the ACF setting "button_label". Returns the default ACF value of the translated
     * string of "Add row" if none has been set using Fewbricks.
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
     * @param string $buttonLabel
     * @return $this
     */
    public function setButtonLabel($buttonLabel)
    {

        return $this->setSetting('button_label', $buttonLabel);

    }

    /**
     * Set a sub field to show when row is collapsed
     *
     * @param string $fieldKey
     * @return $this
     */
    public function setCollapsed($fieldKey)
    {

        return $this->setSetting('collapsed', $fieldKey);

    }

    /**
     * @param string $layout table, block or row
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

    /**
     * Set maximum nr of rows
     *
     * @param int $max
     * @return $this
     */
    public function setMax($max)
    {

        return $this->setSetting('max', $max);

    }

    /**
     * Set minimum nr of rows
     *
     * @param int $min
     * @return $this
     */
    public function setMin($min)
    {

        return $this->setSetting('min', $min);

    }

    /**
     * @param string $key_prefix
     * case
     *
     * @return array|mixed
     */
    public function toAcfArray($key_prefix = '')
    {

        $acfArray = parent::toAcfArray($key_prefix);

        $acfArray = $this->applyCollapsed($acfArray);

        return $acfArray;

    }

}
