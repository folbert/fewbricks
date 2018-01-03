<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Relationship
 * Corresponds to the relationship field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Relationship extends Field implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "elements". Returns the default ACF value of an empty array if none
     * has been set using Fewbricks.
     */
    public function getElements()
    {

        return $this->getSetting('elements', []);

    }

    /**
     * @return mixed The value of the ACF setting "filters". Returns the default ACF value ['search', 'post_type',
     * 'taxonomy] if none has been set using Fewbricks.
     */
    public function getFilters()
    {

        return $this->getSetting('filters', ['search', 'post_type', 'taxonomy']);

    }

    /**
     * @return mixed The value of the ACF setting "max". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getMax()
    {

        return $this->getSetting('max', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getMin()
    {

        return $this->getSetting('min', 0);

    }

    /**
     * @return mixed The value of the ACF setting "post_type". Returns the default ACF value of an empty array  if none
     * has been set using Fewbricks.
     */
    public function getPostType()
    {

        return $this->getSetting('post_type', []);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "object" if none has
     * been
     * set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'object');

    }

    /**
     * @return mixed The value of the ACF setting "taxonomy". Returns the default ACF value of an empty array  if none
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

        return 'relationship';

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

        $this->setSetting('elements', $elements);

        return $this;

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

        $this->setSetting('filters', $filters);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $min
     *
     * @return $this
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

        return $this;

    }

    /**
     * ACF setting. Set which post types to display in drop down.
     *
     * @param array $postType Array with post type names.
     *
     * @return $this
     */
    public function setPostType(array $postType)
    {

        $this->setSetting('post_type', $postType);

        return $this;

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
