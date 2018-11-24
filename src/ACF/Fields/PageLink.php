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

    /**
     * @return mixed The value of the ACF setting "allow_archives". Returns the default ACF value true if none has been
     * set using Fewbricks.
     */
    public function getAllowArchives()
    {

        return $this->getSetting('allow_archives', true);

    }

    /**
     * @return mixed The value of the ACF setting "multiple". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getMultiple()
    {

        return $this->getSetting('multiple', 0);

    }

    /**
     * @return mixed The value of the ACF setting "". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPostType()
    {

        return $this->getSetting('post_type', []);

    }

    /**
     * @return mixed The value of the ACF setting "post_type". Returns the default ACF value of an empty array if none
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

        return 'page_link';

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowArchives
     */
    public function setAllowArchives($allowArchives)
    {

        $this->setSetting('allow_archives', $allowArchives);

    }

    /**
     * ACF setting.
     *
     * @param boolean $multiple
     */
    public function setMultiple($multiple)
    {

        $this->setSetting('multiple', $multiple);

    }

    /**
     * ACF setting.
     *
     * @param array $postType Array with post type names
     */
    public function setPostType(array $postType)
    {

        $this->setSetting('post_type', $postType);

    }

}
