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

    /**
     * ACF setting.
     *
     * @param boolean $allowMutipleValues
     *
     * @return $this
     */
    public function setAllowMultipleValues($allowMutipleValues)
    {

        return $this->setSetting('multiple', $allowMutipleValues);

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowNull
     *
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);

    }

    /**
     * ACF setting.
     *
     * @param array $userRoles Array with names of the user roles that the editor should be able to choose from.
     *                         For example: ['editor', 'author']. Send an empty array (or don't call the function at
     *                         all) to be able to choose from al roles.
     *
     * @return $this
     */
    public function setUserRoles($userRoles)
    {

        return $this->setSetting('role', $userRoles);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'user';

    }

}
