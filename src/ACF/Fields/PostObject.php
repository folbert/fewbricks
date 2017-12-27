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
     * @return mixed The value of the ACF setting "return_formt". Returns the default ACF value "object" if none has
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
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'post_object';

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowNull
     *
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        $this->setSetting('null', $allowNull);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param boolean $multiple
     *
     * @return $this
     */
    public function setMultiple($multiple)
    {

        $this->setSetting('multiple', $multiple);

        return $this;

    }

    /**
     * ACF setting. Set which post types to display in drop down.
     *
     * @param array $postType Array with post type names.
     *
     * @return $this
     */
    public function setPostType($postType)
    {

        $this->setSetting('post_type', $postType);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param $returnFormat "object" for post object or "id" for post id.
     *
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        $this->setSetting('return_format', $returnFormat);

        return $this;

    }

    /**
     * ACF setting. Set which terms post objects available in teh drop down must belong to.
     *
     * @param array $taxonomy        An array where each item is made up of "taxonomy:term". For example
     *                               ["category:uncategorized"]
     *
     * @return $this
     */
    public function setTaxonomy($taxonomy)
    {

        $this->setSetting('taxonomy', $taxonomy);

        return $this;

    }

}
