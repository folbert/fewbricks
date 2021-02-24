<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithFields;

/**
 * Class Layout
 * It extends FieldWithSubFields even though a layout technically speaking is not a field.
 * But it still has so much in common with FieldWithLayouts that it is motivated to extend it.
 *
 * @package Fewbricks\ACF
 */
class Layout extends FieldWithFields implements FieldInterface
{

    const TYPE = 'layout';

    /**
     * @return mixed The value of the ACF setting "display". Returns the default ACF value "block" if none has been
     * set using Fewbricks.
     */
    public function get_display()
    {

        return $this->get_setting('display', 'block');

    }

    /**
     * @return mixed The value of the ACF setting "max". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_max()
    {

        return $this->get_setting('max', '');

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_min()
    {

        return $this->get_setting('min', '');

    }

    /**
     * ACF setting. Sets the value which is set using the select box labelled "Layout" in the GUI
     *
     * @param string $display table, block or row
     * @return $this
     */
    public function set_display($display)
    {

        return $this->set_setting('display', $display);

    }

    /**
     * ACF setting. The max nr of times this layout can be used in the current flexible content.
     *
     * @param int|string $max An empty string to disable this setting which is only needed if you have previously set it
     *                        to an int and wants to unset it.
     * @return $this
     */
    public function set_max($max)
    {

        return $this->set_setting('max', $max);

    }

    /**
     * ACF setting. The min nr of times this layout can be used in the current flexible content.
     *
     * @param int|string $min An empty string to disable this setting which is only needed if you have previously set it
     *                        to an int and wants to unset it.
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

        parent::add_brick($brick);

        // Set the name of the layout to that of the brick.
        $this->name = $brick->get_name();

        return $this;

    }

}
