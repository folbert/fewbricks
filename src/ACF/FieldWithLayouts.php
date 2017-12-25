<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Fields\Layout;
use Fewbricks\KeyInUseException;

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

        $this->setSetting('button_label', $buttonLabel);

        return $this;

    }

    /**
     * @param Layout $layout
     *
     * @return $this
     */
    public function addLayout($layout)
    {

        try {

            $this->layouts->addItem($layout, $layout->getKey());

        } catch (KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

        }

        return $this;

    }

    /**
     * @param int $name
     *
     * @return $this
     */
    public function removeLayout($name)
    {

        $this->layouts->removeItemByName($name);

        return $this;

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
