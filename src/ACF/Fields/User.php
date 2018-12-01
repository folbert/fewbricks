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
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getAllowNull()
    {

        return $this->getSetting('allow_null', false);

    }

    /**
     * @return mixed The value of the ACF setting "multiple". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getMultiple()
    {

        return $this->getSetting('multiple', false);

    }

    /**
     * @return mixed The value of the ACF setting "role". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getRole()
    {

        return $this->getSetting('role', '');

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowNull
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);

    }

    /**
     * ACF setting.
     *
     * @param boolean
     * @return $this
     */
    public function setMultiple($multiple)
    {

        return $this->setSetting('multiple', $multiple);

    }

    /**
     * ACF setting.
     *
     * @param array $role      Array with names of the user roles that the editor should be able to choose from.
     *                         For example: ['editor', 'author']. Send an empty array (or don't call the function at
     *                         all) to be able to choose from al roles.
     * @return $this
     */
    public function setRole(array $role)
    {

        return $this->setSetting('role', $role);

    }

}
