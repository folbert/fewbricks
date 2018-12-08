<?php

/**
 * Don't place your custom file in the Fewbricks plugin directory! You must move it to a place that
 * won't be altered when updating plugins or core.
 * Don't forget to activate the plugin for the extensions for which you are creating the class!
 */

// Make sure to set your own namespace here
//namespace Your\Namespaces;

// Select the correct parent below
use Fewbricks\ACF\Field;
//use Fewbricks\ACF\DateTimeField
//use Fewbricks\ACF\FieldWithChoices
//use Fewbricks\ACF\FieldWithFields
//use Fewbricks\ACF\FieldWithImages
//use Fewbricks\ACF\FieldWithLayouts

// Replace NameOfField with CamelCase version of the value of TYPE below.
// Select the correct parent to extend
class NameOfField extends Field
{

    // Check the v5-file in the extensions plugin folder and copy the value for
    // $this->name and replace name_of_field below with that value. Yes, a constant named TYPE
    // is set to the name of the field. Seems wrong but it is not.
    const TYPE = 'name_of_field';

    /**
     * Taking care of the above is really all you have to do to have the field type up and running. But do yourself a
     * favour and add setters and getters for the field types settings below. Find out the names of the settings by
     * opening the v5-file in the extensions plugin folder and look at the $this->defaults array. If a setting has an
     * array as a value, make sure to send an array with the same keys to $this->setSetting in the code below.
     * Note that you don't have to create functions for the settings that is available to all fields in ACF core like
     * label, name, instructions, required, conditional logic and wrapper. These will be made available via the parent
     * class.
     */

    /**
     * @param $value
     * @return $this
     */
    /*public function setNameOfSetting($value)
    {

        // replace NameOfSetting above with the PascalCase version of what the setting is called in the field.
        // Replace name_of_setting below with what the setting is called in the field.
        // The outcome of $this->>setSetting() is $this which we then return in order
        // to allow for chaining.
        return $this->setSetting('name_of_setting', $value);

    }*/

    /**
     * @return mixed
     */
    /*public function getNameOfSetting()
    {

        // replace NameOfSetting above with the PascalCase version of what the setting is called in the field.
        // Replace name_of_setting with what the setting is called in the field
        // default_value_as_defined_by_the_field should be whatever the field defines to be the
        // default value if nothing has been set. This will not affect anything when creating
        // the field but will help if you want to get the setting without it ever having been set.
        return $this->getSetting('name_of_setting', 'default_value_as_defined_by_the_field');

    }*/



}
