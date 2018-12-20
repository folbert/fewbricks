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
     * @return mixed The value of the ACF setting "". Returns the default ACF value [] if none has been
     * set using Fewbricks.
     */
    public function getPostType()
    {

        return $this->getSetting('post_type', []);

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
     * @param mixed $allowArchives
     * @return $this
     */
    public function setAllowArchives($allowArchives)
    {

        return $this->setSetting('allow_archives', $allowArchives);

    }

    /**
     * ACF setting.
     *
     * @param mixed $multiple
     * @return $this
     */
    public function setMultiple(bool $multiple)
    {

        return $this->setSetting('multiple', $multiple);

    }

    /**
     * ACF setting.
     *
     * @param mixed $postType Array with post type names
     * @return $this
     */
    public function setPostType(array $postType)
    {

        return $this->setSetting('post_type', $postType);

    }

    /**
     * ACF setting.
     *
     * @param mixed $taxonomy Array with post type names
     * @return $this
     */
    public function setTaxonomy(array $taxonomy)
    {

        return $this->setSetting('taxonomy', $taxonomy);

    }

}
