<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class User
 * Corresponds to the user field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class User extends Field
{

    /**
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param array  $void     Not used. Exists only to match the nr of args of parent
     *                         constructor.
     */
    public function __construct(
        $label,
        $name,
        $key,
        $settings = [],
        $void = null
    ) {

        parent::__construct('user', $label, $name, $key, $settings);

    }

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

}
