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
     * @param array $settings
     */
    public function __construct(
        $label,
        $name,
        $key,
        array $settings = []
    )
    {

        parent::__construct($label, $name, $key, $settings);

        $this->layouts = new LayoutCollection();
        $this->layouts->setBaseKey($key);

    }

    /**
     * @param $layout
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
     * @param int $key
     * @return mixed
     */
    public function getLayout($key)
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
     * @param int $name
     * @return $this
     */
    public function removeLayout($name)
    {

        $this->layouts->removeFieldByName($name);

        return $this;

    }

    /**
     * @param $buttonLabel
     * @return $this
     */
    public function setButtonLabel($buttonLabel)
    {

        return $this->setSetting('button_label', $buttonLabel);

    }

    /**
     * @param array $extra_settings Any extra settings that you want to apply at the last minute. Be careful not to set
     * such items from the array in case you really want to set them, crucial settings like "key" and
     * "conditional_logic" here.
     *
     * @return array
     */
    public function toAcfArray(array $extra_settings = [])
    {

        $settings = parent::toAcfArray($extra_settings);

        $settings['layouts'] = $this->layouts->toAcfArray();

        return $settings;

    }

}
