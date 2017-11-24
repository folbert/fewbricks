<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\LayoutCollection;

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
     * @param string $type
     * @param string $label
     * @param string $name
     * @param string $key
     * @param array  $settings
     */
    public function __construct(
        $type,
        $label,
        $name,
        $key,
        array $settings = []
    ) {

        parent::__construct($type, $label, $name, $key, $settings);

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
     * @return array
     */
    public function getSettings()
    {

        $settings = parent::getSettings();

        $settings['layouts'] = $this->layouts->getFinalizedSettings($this->key);

        return $settings;

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

}
