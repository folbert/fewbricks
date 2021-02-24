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

    const TYPE = 'relationship';

    /**
     * @return mixed The value of the ACF setting "elements". Returns the default ACF value of an empty array if none
     * has been set using Fewbricks.
     */
    public function get_elements()
    {

        return $this->get_setting('elements', []);

    }

    /**
     * @return mixed The value of the ACF setting "filters". Returns the default ACF value ['search', 'post_type',
     * 'taxonomy] if none has been set using Fewbricks.
     */
    public function get_filters()
    {

        return $this->get_setting('filters', ['search', 'post_type', 'taxonomy']);

    }

    /**
     * @return mixed The value of the ACF setting "max". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_max()
    {

        return $this->get_setting('max', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_min()
    {

        return $this->get_setting('min', 0);

    }

    /**
     * @return mixed The value of the ACF setting "post_type". Returns the default ACF value of an empty array  if none
     * has been set using Fewbricks.
     */
    public function get_post_type()
    {

        return $this->get_setting('post_type', []);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "object" if none has
     * been
     * set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'object');

    }

    /**
     * @return mixed The value of the ACF setting "taxonomy". Returns the default ACF value of an empty array if none
     * has been set using Fewbricks.
     */
    public function get_taxonomy()
    {

        return $this->get_setting('taxonomy', []);

    }

    /**
     * ACF setting.
     *
     * @param array $elements Name of elements to display
     * @return $this
     */
    public function set_elements($elements)
    {

        return $this->set_setting('elements', $elements);

    }

    /**
     * ACF setting.
     *
     * @param array $filters Which filters should be available to the administrator. Possible values: "search",
     *                       "post_type", "taxonomy".
     * @return $this
     */
    public function set_filters($filters)
    {

        return $this->set_setting('filters', $filters);

    }

    /**
     * ACF setting.
     *
     * @param int $max
     * @return $this
     */
    public function set_max($max)
    {

        return $this->set_setting('max', $max);

    }

    /**
     * ACF setting.
     *
     * @param int $min
     * @return $this
     */
    public function set_min($min)
    {

        return $this->set_setting('min', $min);

    }

    /**
     * ACF setting. Set which post types to display in drop down.
     *
     * @param array $post_type Array with post type names.
     * @return $this
     */
    public function set_post_type($post_type)
    {

        return $this->set_setting('post_type', $post_type);

    }

    /**
     * ACF setting.
     *
     * @param string $return_format "object" or "id"
     * @return $this
     */
    public function set_return_format($return_format)
    {

        return $this->set_setting('return_format', $return_format);

    }

    /**
     * ACF setting. Set which terms post objects available in the drop down must belong to.
     *
     * @param array $taxonomy        An array where each item is made up of "taxonomy:term". For example
     *                               ["category:uncategorized"]
     * @return $this
     */
    public function set_taxonomy($taxonomy)
    {

        return $this->set_setting('taxonomy', $taxonomy);

    }

}
