<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Relationship
 * Corresponds to the relationship field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Relationship extends Field
{

    /**
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param array  $void     Not used. Exists only to match the nr of args of parent
     *                         constructor.
     */
    public function __construct(
        $label,
        $name,
        $key,
        $settings = [],
        $void = null
    ) {

        parent::__construct('relationship', $label, $name, $key, $settings);

    }

    /**
     * ACF setting.
     *
     * @param array $elements Name of elements to display
     *
     * @return $this
     */
    public function setElements($elements)
    {

        return $this->setSetting('elements', $elements);

    }

    /**
     * ACF setting.
     *
     * @param array $filters Which filters should be available to the administrator. Possible values: "search",
     *                       "post_type", "taxonomy".
     *
     * @return $this
     */
    public function setFilters($filters)
    {

        return $this->setSetting($filters);

    }

    /**
     * ACF setting.
     *
     * @param int $maximumPosts
     *
     * @return $this
     */
    public function setMaximumPosts($maximumPosts)
    {

        return $this->setSetting('max', $maximumPosts);

    }

    /**
     * ACF setting.
     *
     * @param int $minimumPosts
     *
     * @return $this
     */
    public function setMinimumPosts($minimumPosts)
    {

        return $this->setSetting('min', $minimumPosts);

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
     * @param string $returnFormat "object" or "id"
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
     * @param array $taxonomyFilter  An array where each item is made up of "taxonomy:term". For example
     *                               ["category:uncategorized"]
     *
     * @return $this
     */
    public function setTaxonomyFilter($taxonomyFilter)
    {

        return $this->setSetting('taxonomy', $taxonomyFilter);

    }

}
