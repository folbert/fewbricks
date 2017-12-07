<?php

namespace Fewbricks\ACF;

/**
 * Class ItemWithLayouts
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
     * @param array  $settings
     */
    public function __construct(
        $label,
        $name,
        $key,
        array $settings = []
    ) {

        parent::__construct($label, $name, $key, $settings);

        $this->layouts = new LayoutCollection();

    }

    /**
     * @param $buttonLabel
     *
     * @return $this
     */
    public function setButtonLabel($buttonLabel)
    {

        return $this->setSetting('button_label', $buttonLabel);

    }

    /**
     * @param Layout $layout
     * @param null   $key
     *
     * @return $this
     */
    public function addLayout($layout, $key = null)
    {

        return $this->layouts->addItem($layout, $key);

    }

    /**
     * @param int $key
     *
     * @return $this
     */
    public function deleteLayout($key)
    {

        return $this->layouts->deleteItem($key);

    }

    /**
     * @return mixed The value of the ACF setting "button_label". Returns the default ACF value "Add row" (or
     * translation thereof) if none has been set using Fewbricks.
     */
    public function getButtonLabel()
    {

        return $this->getSetting('max', __('Add Row', 'acf'));

    }

    /**
     * @param int $key
     *
     * @return mixed
     */
    public function getLayout($key)
    {

        return $this->layouts->getItem($key);

    }

    /**
     * @return LayoutCollection
     */
    public function getLayouts()
    {

        return $this->layouts;

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        $settings = parent::toAcfArray();

        $settings['layouts'] = $this->layouts->getFinalizedSettings($this->key);

        return $settings;

    }

}
