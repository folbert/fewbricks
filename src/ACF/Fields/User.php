<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class User
 * Corresponds to the user field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class User extends Field implements FieldInterface
{

    const TYPE = 'user';

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
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has
     * been set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'array'); //

    }

    /**
     * @return mixed The value of the ACF setting "role". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_role()
    {

        return $this->get_setting('role', ''); //

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
     * @param boolean
     * @return $this
     */
    public function set_multiple($multiple)
    {

        return $this->set_setting('multiple', $multiple);

    }

    /**
     * ACF setting.
     *
     * @param string $return_format
     * @return $this
     */
    public function set_return_format($return_format)
    {

        return $this->set_setting('return_format', $return_format);

    }

    /**
     * ACF setting.
     *
     * @param array $role      Array with names of the user roles that the editor should be able to choose from.
     *                         For example: ['editor', 'author']. Send an empty array (or don't call the function at
     *                         all) to be able to choose from all roles.
     * @return $this
     */
    public function set_role($role)
    {

        return $this->set_setting('role', $role);

    }

}
