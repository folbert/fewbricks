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
     * @return mixed The value of the ACF setting "add_term". Returns the default ACF value 1 if none has been
     * set using Fewbricks.
     */
    public function get_add_term()
    {

        return $this->get_setting('add_term', 1);

    }

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_allow_null()
    {

        return $this->get_setting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting "field_type". Returns the default ACF value "checkbox" if none has
     * been
     * set using Fewbricks.
     */
    public function get_field_type()
    {

        return $this->get_setting('field_type', 'checkbox');
    }

    /**
     * @return mixed The value of the ACF setting "load_terms". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_load_terms()
    {

        return $this->get_setting('load_terms', 0);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "id" if none has been
     * set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'id');

    }

    /**
     * @return mixed The value of the ACF setting "save_terms". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_save_terms()
    {

        return $this->get_setting('save_terms', 0);

    }

    /**
     * @return mixed The value of the ACF setting "taxonomy". Returns the default ACF value "category" if none has been
     * set using Fewbricks.
     */
    public function get_taxonomy()
    {

        return $this->get_setting('taxonomy', 'category');

    }

    /**
     * ACF setting. Set if new terms can be added whilst editing.
     *
     * @param boolean $addTerm
     * @return $this
     */
    public function set_add_term($addTerm)
    {

        return $this->set_setting('add_term', $addTerm);

    }

    /**
     * ACF settings.
     *
     * @param $allowNull
     * @return $this
     */
    public function set_allow_null($allowNull)
    {

        return $this->set_setting('allow_null', $allowNull);

    }

    /**
     * ACF setting. NOt what kind of field this is but what kind of field to use when displaying the terms
     *
     * @param string $field_type "checkbox", "radio", "multi_select" or "select"
     * @return $this
     */
    public function set_field_type($field_type)
    {

        return $this->set_setting('field_type', $field_type);

    }

    /**
     * ACF settings. Set if value should be loaded from posts terms.
     *
     * @param $loadTerms
     * @return $this
     */
    public function set_load_terms($loadTerms)
    {

        return $this->set_setting('load_terms', $loadTerms);

    }

    /**
     * ACF setting.
     *
     * @param string $returnFormat "object" or "id"
     * @return $this
     */
    public function set_return_format($returnFormat)
    {

        return $this->set_setting('return_format', $returnFormat);

    }

    /**
     * ACF setting. Set if selected terms should be connected to the post.
     *
     * @param boolean $saveTerms
     * @return $this
     */
    public function set_save_terms($saveTerms)
    {

        return $this->set_setting('save_terms', $saveTerms);

    }

    /**
     * ACF setting. Set the taxonomy to be displayed.
     *
     * @param string $taxonomy The name of a taxonomy
     * @return $this
     */
    public function set_taxonomy($taxonomy)
    {

        return $this->set_setting('taxonomy', $taxonomy);

    }

}
