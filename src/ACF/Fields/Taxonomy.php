<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Taxonomy
 * Corresponds to the taxonomy field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Taxonomy extends Field implements FieldInterface
{

    const TYPE = 'taxonomy';

    /**
     * @return mixed The value of the ACF setting "add_term". Returns the default ACF value true if none has been
     * set using Fewbricks.
     */
    public function getAddTerm()
    {

        return $this->getSetting('add_term', true);

    }

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getAllowNull()
    {

        return $this->getSetting('allow_null', false);

    }

    /**
     * @return mixed The value of the ACF setting "field_type". Returns the default ACF value "checkbox" if none has
     * been
     * set using Fewbricks.
     */
    public function getFieldType()
    {

        return $this->getSetting('field_type', 'checkbox');
    }

    /**
     * @return mixed The value of the ACF setting "load_terms". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getLoadTerms()
    {

        return $this->getSetting('load_terms', false);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "id" if none has been
     * set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'id');

    }

    /**
     * @return mixed The value of the ACF setting "save_terms". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getSaveTerms()
    {

        return $this->getSetting('save_terms', false);

    }

    /**
     * @return mixed The value of the ACF setting "taxonomy". Returns the default ACF value "category" if none has been
     * set using Fewbricks.
     */
    public function getTaxonomy()
    {

        return $this->getSetting('taxonomy', 'category');

    }

    /**
     * ACF setting. Set if new terms can be added whilst editing.
     *
     * @param boolean $addTerm
     * @return $this
     */
    public function setAddTerm($addTerm)
    {

        return $this->setSetting('add_term', $addTerm);

    }

    /**
     * ACF settings.
     *
     * @param $allowNull
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);

    }

    /**
     * ACF setting. NOt what kind of field this is but what kind of field to use when displaying the terms
     *
     * @param string $field_type "checkbox", "radio", "multi_select" or "select"
     * @return $this
     */
    public function setFieldType($field_type)
    {

        return $this->setSetting('field_type', $field_type);

    }

    /**
     * ACF settings. Set if value should be loaded from posts terms.
     *
     * @param $loadTerms
     * @return $this
     */
    public function setLoadTerms($loadTerms)
    {

        return $this->setSetting('load_terms', $loadTerms);

    }

    /**
     * ACF setting.
     *
     * @param string $returnFormat "object" or "id"
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

    /**
     * ACF setting. Set if selected terms should be connected to the post.
     *
     * @param boolean $saveTerms
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
     * @return $this
     */
    public function setTaxonomy($taxonomy)
    {

        return $this->setSetting('taxonomy', $taxonomy);

    }

}
