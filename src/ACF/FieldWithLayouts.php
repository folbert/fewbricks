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
    public function addLayout($layout)
    {

        $this->layouts->addItem($layout, $layout->getKey());

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "button_label". Returns the default ACF value "Add row" (or
     * translation thereof) if none has been set using Fewbricks.
     */
    public function getButtonLabel()
    {

        return $this->getSetting('button_label', __('Add Row', 'acf'));

    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getLayout(string $key)
    {

        return $this->layouts->getItemByKey($key);

    }

    /**
     * @return LayoutCollection
     */
    public function getLayouts()
    {

        return $this->layouts;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeLayout(string $name)
    {

        $this->layouts->removeFieldByName($name);

        return $this;

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
     * @param string $keyPrefix
     *
     * @return array
     */
    public function toAcfArray(string $keyPrefix = '')
    {

        $settings = parent::toAcfArray($keyPrefix);

        $settings['layouts'] = $this->layouts->toAcfArray($settings['key']);

        return $settings;

    }

}
