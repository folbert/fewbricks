<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Fields\Layout;

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
     * @param string $buttonLabel
     * @return $this
     */
    public function set_button_label($buttonLabel)
    {

        return $this->set_setting('button_label', $buttonLabel);

    }

    /**
     * @param string $keyPrefix
     *
     * @return array
     */
    public function to_acf_array(string $keyPrefix = '')
    {

        $settings = parent::to_acf_array($keyPrefix);

        $settings['layouts'] = $this->layouts->to_acf_array($settings['key']);

        return $settings;

    }

}
