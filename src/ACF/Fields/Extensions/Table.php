<?php

namespace Fewbricks\ACF\Fields\Extensions;

use Fewbricks\ACF\Field;

class Table extends Field
{

    const TYPE = 'table';

    /**
     * @param $value 1 for "yes" or or 2 for "no"
     * @return $this
     */
    public function setUseCaption($value)
    {

        return $this->setSetting('use_caption', $value);

    }

    /**
     * @param $value 0 for "optional", 1 for "yes" or or 2 for "no"
     * @return $this
     */
    public function setUseHeader($value)
    {

        return $this->setSetting('use_header', $value);

    }

    /**
     * @return mixed
     */
    public function getUseCaption()
    {

        return $this->getSetting('use_caption', 2);

    }

    /**
     * @return mixed
     */
    public function getUseHeader()
    {

        return $this->getSetting('use_header', 0);

    }

    /**
     * @param array $extraSettings
     * @return array
     */
    public function toAcfArray(array $extraSettings = [])
    {

        // Fix since the field does not check if indexes are set before using the value.
        if($this->getSetting('use_caption', false) === false) {
            $this->setUseCaption(2);
        }

        if($this->getSetting('use_header', false) === false) {
            $this->setUseHeader(0);
        }

        return parent::toAcfArray($extraSettings);

    }

}
