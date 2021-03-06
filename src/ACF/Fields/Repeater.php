<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithFields;
use Fewbricks\ACF\Traits\RowLogic;
use Fewbricks\Helpers\Helper;

/**
 * Class Repeater
 * Corresponds to the repeater field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Repeater extends FieldWithFields implements FieldInterface
{

    use RowLogic;

    const TYPE = 'repeater';

    /**
     * @param $acf_array
     *
     * @return mixed
     */
    private function apply_collapsed($acf_array)
    {

        if ($this->get_setting('collapsed', 0) != 0) {

            $new_key = Helper::get_new_key_by_original_key_in_acf_array($this->get_setting('collapsed'),
                $acf_array['sub_fields']);

            if ($new_key !== false) {
                $acf_array['collapsed'] = $new_key;
            }

        }

        return $acf_array;

    }

    /**
     * @return mixed The value of the ACF setting "button_label". Returns the default ACF value "" if none
     * has been set using Fewbricks.
     */
    public function get_button_label()
    {

        return $this->get_setting('button_label', '');

    }

    /**
     * @return mixed The value of the ACF setting "collapsed". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_collapsed()
    {

        return $this->get_setting('collapsed', '');

    }

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "table" if none has been
     * set using Fewbricks.
     */
    public function get_layout()
    {

        return $this->get_setting('layout', 'table');

    }

    /**
     * @return mixed The value of the ACF setting "m0". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_max()
    {

        return $this->get_setting('max', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_min()
    {

        return $this->get_setting('min', 0);

    }

    /**
     * @param string $button_label
     * @return $this
     */
    public function set_button_label($button_label)
    {

        return $this->set_setting('button_label', $button_label);

    }

    /**
     * Set a sub field to show when row is collapsed
     *
     * @param string $field_key
     * @return $this
     */
    public function set_collapsed($field_key)
    {

        return $this->set_setting('collapsed', $field_key);

    }

    /**
     * @param string $layout table, block or row
     * @return $this
     */
    public function set_layout($layout)
    {

        return $this->set_setting('layout', $layout);

    }

    /**
     * Set maximum nr of rows
     *
     * @param int $max
     * @return $this
     */
    public function set_max($max)
    {

        return $this->set_setting('max', $max);

    }

    /**
     * Set minimum nr of rows
     *
     * @param int $min
     * @return $this
     */
    public function set_min($min)
    {

        return $this->set_setting('min', $min);

    }

    /**
     * @param \Fewbricks\Brick $brick
     * @return FieldWithFields
     */
    public function add_brick($brick)
    {

        $brick->prepare_for_add_to_field_with_fields();

        return parent::add_brick($brick);
    }

    /**
     * @param string $key_prefix
     * case
     *
     * @return array|mixed
     */
    public function to_acf_array(string $key_prefix = '')
    {

        $acf_array = parent::to_acf_array($key_prefix);

        $acf_array = $this->apply_collapsed($acf_array);

        return $acf_array;

    }

}
