<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class PostObject
 * Corresponds to the post object field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class PostObject extends Field
{

    /**
     * @var string The ACF field type
     */
    protected $type = 'post_object';

    /**
     * ACF setting.
     *
     * @param boolean $allowNull
     *
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('null', $allowNull);

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowMultipleValues
     *
     * @return $this
     */
    public function setAllowMultipleValues($allowMultipleValues)
    {

        return $this->setSetting('multiple', $allowMultipleValues);

    }

    /**
     * ACF setting. Set which post types to display in drop down.
     *
     * @param array $postType Array with post type names.
     *
     * @return $this
     */
    public function setPostTypes($postType)
    {

        return $this->setSetting('post_type', $postType);

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

        return $this->setSetting('return_format', $returnFormat);

    }

    /**
     * ACF setting. Set which terms post objects available in teh drop down must belong to.
     *
     * @param array $taxonomyFilter An array where each item is made up of "taxonomy:term". For example
     *                               ["category:uncategorized"]
     *
     * @return $this
     */
    public function setTaxonomyFilter($taxonomyFilter)
    {

        return $this->setSetting('taxonomy', $taxonomyFilter);

    }

}
