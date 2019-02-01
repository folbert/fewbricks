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
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_allow_null()
    {

        return $this->get_setting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting multiple. Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_multiple()
    {

        return $this->get_setting('multiple', 0);

    }

    /**
     * @return mixed The value of the ACF setting "post_type". Returns the default ACF value of an empty array if none
     * has been set using Fewbricks.
     */
    public function get_post_type()
    {

        return $this->get_setting('post_type', []);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "object" if none has
     * been set using Fewbricks.
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
     * @param boolean $allow_null
     * @return $this
     */
    public function set_allow_null($allow_null)
    {

        return $this->set_setting('allow_null', $allow_null);

    }

    /**
     * ACF setting.
     *
     * @param boolean $multiple
     * @return $this
     */
    public function set_multiple($multiple)
    {

        return $this->set_setting('multiple', $multiple);

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
     * @param $return_format "object" for post object or "id" for post id.
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
