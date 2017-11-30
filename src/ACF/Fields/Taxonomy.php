<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Taxonomy
 * Corresponds to the taxonomy field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Taxonomy extends Field implements FieldInterface
{

    /**
     * ACF settings.
     *
     * @param $allowNull
     *
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);

    }

    /**
     * ACF setting.
     *
     * @param string $appearance "checkbox", "radio", "multi_select" or "select"
     *
     * @return $this
     */
    public function setAppearance($appearance)
    {

        return $this->setSetting('field_type', $appearance);

    }

    /**
     * ACF setting. Set if new terms can be added whilst editing.
     *
     * @param boolean $createTerms
     *
     * @return $this
     */
    public function setCreateTerms($createTerms)
    {

        return $this->setSetting('add_term', $createTerms);

    }

    /**
     * ACF settings. Set if value should be loaded from posts terms.
     *
     * @param $loadTerms
     *
     * @return $this
     */
    public function setLoadTerms($loadTerms)
    {

        return $this->setSetting('load_terms', $loadTerms);

    }

    /**
     * ACF setting.
     *
     * @param string $returnValue "object" or "id"
     *
     * @return $this
     */
    public function setReturnValue($returnValue)
    {

        return $this->setSetting('return_format', $returnValue);

    }

    /**
     * ACF setting. Set if selected terms should be connected to the post.
     *
     * @param boolean $saveTerms
     *
     * @return $this
     */
    public function setSaveTerms($saveTerms)
    {

        return $this->setSetting('save_terms', $saveTerms);

    }


    /**
     * ACF setting. Set the taxonomy to be displayed.
     *
     * @param string $taxonomy The name of a taxonomy
     *
     * @return $this
     */
    public function setTaxonomy($taxonomy)
    {

        return $this->setSetting('taxonomy', $taxonomy);

    }

    /**
     * @return string The ACF type
     */
    public function getType()
    {

        return 'taxonomy';

    }

}
