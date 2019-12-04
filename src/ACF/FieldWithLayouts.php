<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Fields\Layout;
use Fewbricks\Brick;

/**
 * Class FieldWithLayouts
 *
 * @package Fewbricks\ACF
 */
class FieldWithLayouts extends Field
{

    /**
     * @var array
     */
    protected $layouts;

    /**
     * FieldWithLayouts constructor.
     *
     * @param string $label
     * @param string $name
     * @param string $key
     */
    public function __construct($label, $name, $key)
    {

        parent::__construct($label, $name, $key);

        $this->layouts = new LayoutCollection($key);

    }

    /**
     * @param Layout $layout
     * @return $this
     */
    public function add_layout($layout)
    {

        $this->layouts->add_item($layout, $layout->get_key());

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "button_label". Returns the default ACF value "Add row" (or
     * translation thereof) if none has been set using Fewbricks.
     */
    public function get_button_label()
    {

        return $this->get_setting('button_label', __('Add Row', 'acf'));

    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get_layout(string $key)
    {

        return $this->layouts->get_item_by_key($key);

    }

    /**
     * @return LayoutCollection
     */
    public function get_layouts()
    {

        return $this->layouts;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function remove_layout(string $name)
    {

        $this->layouts->remove_field_by_name($name);

        return $this;

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
     * @return Brick
     */
    public function get_brick_in_row() {

        $row_layout = get_row_layout();

        $class_name = get_sub_field($row_layout . '_' . \Fewbricks\Brick::BRICK_CLASS_FIELD_NAME);

        /** @var Brick $brick_instance */
        $brick_instance = new $class_name('', $row_layout);

        $brick_instance->set_row_layout($row_layout);
        $brick_instance->set_is_layout(true);
        $brick_instance->set_is_option($this->is_option);

        return $brick_instance;

    }

    /**
     * Wrapper function for ACFs have_rows()
     * @param bool $post_id Specific post ID where your value was entered.
     * Defaults to current post ID (not required). This can also be options / taxonomies / users / etc
     * See https://www.advancedcustomfields.com/resources/have_rows/
     * @return bool
     */
    public function have_rows($post_id = false)
    {

        dump('Loop');
        dump(acf_get_loop('active'));

        if($post_id !== false) {
            $outcome = have_rows($this->name, $post_id);
        } elseif ($this->is_option) {
            $outcome = have_rows($this->name, 'option');
        } else {
            dump('Checking for');
            dump($this->name);
            $outcome = have_rows($this->name);
        }

        return $outcome;

    }

    /**
     * Wrapper function for ACFs the_row to avoid confusion on when to use $this or not for ACF functions.
     */
    public function the_row()
    {

        the_row();

    }

    /**
     * @param string $key_prefix
     *
     * @return array
     */
    public function to_acf_array(string $key_prefix = '')
    {

        $settings = parent::to_acf_array($key_prefix);

        $settings['layouts'] = $this->layouts->to_acf_array($settings['key']);

        return $settings;

    }

}
