<?php

namespace Fewbricks\ACF\Traits;

/**
 * Trait RowLogic
 * @package Fewbricks\ACF\Traits
 */
trait RowLogic
{

    /**
     * Wrapper function for ACFs have_rows()
     * @param bool $post_id Specific post ID where your value was entered.
     * Defaults to current post ID (not required). This can also be options / taxonomies / users / etc
     * See https://www.advancedcustomfields.com/resources/have_rows/
     * @return bool
     */
    public function have_rows($post_id = false)
    {

        if($post_id !== false) {
            $outcome = have_rows($this->name, $post_id);
        } elseif ($this->is_option) {
            $outcome = have_rows($this->name, 'option');
        } else {
            $outcome = have_rows($this->name);
        }

        return $outcome;

    }

    /**
     * Wrapper function for ACFs the_row to avoid confusion on when to use $this or not for ACF functions.
     */
    public function the_row()
    {

        the_row();

    }

}
