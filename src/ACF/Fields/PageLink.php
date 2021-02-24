<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class PageLink
 * Corresponds to the page link field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class PageLink extends Field implements FieldInterface
{

    const TYPE = 'page_link';

    /**
     * @return mixed The value of the ACF setting "allow_archives". Returns the default ACF value 1 if none has been
     * set using Fewbricks.
     */
    public function get_allow_archives()
    {

        return $this->get_setting('allow_archives', 1);

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
     * @return mixed The value of the ACF setting "multiple". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_multiple()
    {

        return $this->get_setting('multiple', 0);

    }

    /**
     * @return mixed The value of the ACF setting "". Returns the default ACF value [] if none has been
     * set using Fewbricks.
     */
    public function get_post_type()
    {

        return $this->get_setting('post_type', []);

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
     * @param mixed $allow_archives
     * @return $this
     */
    public function set_allow_archives($allow_archives)
    {

        return $this->set_setting('allow_archives', $allow_archives);

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
     * @param mixed $multiple
     * @return $this
     */
    public function set_multiple(bool $multiple)
    {

        return $this->set_setting('multiple', $multiple);

    }

    /**
     * ACF setting.
     *
     * @param mixed $post_type Array with post type names
     * @return $this
     */
    public function set_post_type(array $post_type)
    {

        return $this->set_setting('post_type', $post_type);

    }

    /**
     * ACF setting.
     *
     * @param mixed $taxonomy Array with post type names
     * @return $this
     */
    public function set_taxonomy(array $taxonomy)
    {

        return $this->set_setting('taxonomy', $taxonomy);

    }

}
