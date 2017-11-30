<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Select
 * Corresponds to the select field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Select extends FieldWithChoices
{

    /**
     * @var string The ACF field type
     */
    protected $type = 'select';

    /**
     * ACF setting. If AJAX should be used to lazy load the choices.
     *
     * @param boolean $lazyLoad
     *
     * @return $this
     */
    public function setLazyLoad($lazyLoad)
    {

        return $this->setSetting('ajax', $lazyLoad);

    }

    /**
     * ACF settings. Whether or not to use the stylised UI:
     *
     * @param boolean $stylisedUi
     *
     * @return $this
     */
    public function setStylisedUi($stylisedUi)
    {

        return $this->setSetting('ui', $stylisedUi);

    }

}
