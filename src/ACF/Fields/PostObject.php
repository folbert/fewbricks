<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class PostObject
 * Corresponds to the post object field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class PostObject extends Field implements FieldInterface
{

    const TYPE = 'post_object';

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getAllowNull()
    {

        return $this->getSetting('allow_null', false);

    }

    /**
     * @return mixed The value of the ACF setting multiple. Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getMultiple()
    {

        return $this->getSetting('multiple', false);

    }

    /**
     * @return mixed The value of the ACF setting "post_type". Returns the default ACF value of an empty array if none
     * has been set using Fewbricks.
     */
    public function getPostType()
    {

        return $this->getSetting('post_type', []);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "object" if none has
     * been set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'object');

    }

    /**
     * @return mixed The value of the ACF setting "taxonomy". Returns the default ACF value of an empty array if none
     * has been set using Fewbricks.
     */
    public function getTaxonomy()
    {

        return $this->getSetting('taxonomy', []);

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowNull
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('null', $allowNull);

    }

    /**
     * ACF setting.
     *
     * @param boolean $multiple
     * @return $this
     */
    public function setMultiple($multiple)
    {

        return $this->setSetting('multiple', $multiple);

    }

    /**
     * ACF setting. Set which post types to display in drop down.
     *
     * @param array $postType Array with post type names.
     * @return $this
     */
    public function setPostType(array $postType)
    {

        return $this->setSetting('post_type', $postType);

    }

    /**
     * ACF setting.
     *
     * @param $returnFormat "object" for post object or "id" for post id.
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

    /**
     * ACF setting. Set which terms post objects available in teh drop down must belong to.
     *
     * @param array $taxonomy        An array where each item is made up of "taxonomy:term". For example
     *                               ["category:uncategorized"]
     * @return $this
     */
    public function setTaxonomy(array $taxonomy)
    {

        return $this->setSetting('taxonomy', $taxonomy);

    }

}
