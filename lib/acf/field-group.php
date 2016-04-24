<?php

namespace fewbricks\acf;

// If we are in dev mode...
if(\fewbricks\helpers\is_fewbricks_in_developer_mode()) {

    // Create place to keep keys of all fields/bricks etc.
    global $debug_keys;
    $debug_keys = [];

}

/**
 * Class field_group
 * @package fewbricks\acf
 */
class field_group
{

    /**
     * @var array
     */
    private $settings;

    /**
     * @param string $title The text to be displayed as title to the administrator.
     * @param string $key This must be unique across the site. A god idea is to use the current time and then add a
     * random character. Like so: 1509011031t for September 1st, 2015 @ 10:31.
     * @param array $location Where the field group should be displayed.
     * @param int $menu_order Where the field group should be positioned.
     * @param array $settings This allows us to set any setting that a field group can have. See $base_settins for
     * available options.
     */
    public function __construct($title, $key, $location, $menu_order = 1, $settings = [])
    {

        // Since the result of using this class will be an array,
        // we might as well store everything in an array right away.
        $base_settings = [
            'key' => $key,
            'title' => $title,
            'fields' => [],
            'location' => $location,
            'menu_order' => $menu_order,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => []
        ];

        $this->settings = array_merge($base_settings, $settings);

    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set_setting($key, $value)
    {

        $this->settings[$key] = $value;

        return $this;

    }

    /**
     * @param $key
     * @param string $default_value
     * @return string
     */
    public function get_setting($key, $default_value = '')
    {

        $value = $default_value;

        if (isset($this->settings[$key])) {

            $value = $this->settings[$key];

        }

        return $value;

    }

    /**
     * @return array
     */
    public function get_settings()
    {

        return $this->settings;

    }

    /**
     * @param \fewbricks\acf\fields\field $field
     * @return $this
     */
    public function add_field($field)
    {

        $this->settings['fields'][] = $field->get_settings($this);

        return $this;

    }

    /**
     * @param \fewbricks\bricks\brick $brick
     * @return $this
     */
    public function add_brick($brick)
    {

        // Add the fields of the brick to the fields of the brick
        $this->set_setting('fields', array_merge($this->get_setting('fields'), $brick->get_settings($this)['fields']));

        return $this;

    }

    /**
     * @param string $common_field_array_key A key corresponding to an item in the fewbricks_common_fields array
     * @param string $key A site wide unique key for the field
     * @param array $settings Anye extra settings to set on the field. Can be used to override existing settings as well.
     */
    public function add_common_field($common_field_array_key, $key, $settings = [])
    {

        global $fewbricks_common_fields;

        if (isset($fewbricks_common_fields[$common_field_array_key])) {

            $field = clone $fewbricks_common_fields[$common_field_array_key];
            /** @noinspection PhpUndefinedMethodInspection */
            $field->set_setting('key', $key);
            /** @noinspection PhpUndefinedMethodInspection */
            $field->set_settings($settings);
            $this->add_field($field);

        }

    }

    /**
     * @param \fewbricks\acf\fields\flexible_content $flexible_content
     * @return fields\flexible_content
     */
    public function add_flexible_content($flexible_content)
    {

        $this->settings['fields'][] = $flexible_content->get_settings($this);

        return $flexible_content;

    }

    /**
     * Register a field group.
     */
    public function register()
    {

        global $fewbricks_save_json;

        if (!isset($this->settings['names_of_items_to_hide_on_screen']) && !isset($this->settings['names_of_items_to_show_on_screen'])) {

            $this->settings['hide_on_screen'] = $this->get_hide_on_screen_settings();

        } elseif (isset($this->settings['names_of_items_to_show_on_screen'])) {

            $this->settings['hide_on_screen'] = $this->get_hide_on_screen_settings(false,
                $this->settings['names_of_items_to_show_on_screen']);

        } else {

            $this->settings['hide_on_screen'] = $this->get_hide_on_screen_settings(
                $this->settings['names_of_items_to_hide_on_screen'], false);

        }

        $this->settings['fields'] = $this->set_unique_keys($this->settings['fields'], $this->settings['key']);

        if(\fewbricks\helpers\is_fewbricks_in_developer_mode()) {

            if($fewbricks_save_json === true) {

                $this->save_json();

            } elseif (isset($_GET['dumpfewbricksfields'])) {

                $this->print_settings();

            } else {

                $this->check_keys($this->settings['fields']);

            }

        }

        register_field_group($this->settings);

    }

    /**
     * In order to create unique keys, we prepend teh key of a parent to its kids and so on down the field settings tree.
     * @param $fields
     * @param $base_key
     * @return mixed
     */
    private function set_unique_keys($fields, $base_key)
    {

        foreach ($fields as $field_key => $field_settings) {

            // Store the original key to ease debugging
            $fields[$field_key]['original_key'] = $fields[$field_key]['key'];

            // Start off new key with base key
            $new_key = $base_key;

            // Lets add the brick key if we have one. This will only be set if
            // the field is part of a brick (which is a concept added by Fewbricks and of which ACF has no idea)
            if(isset($field_settings['brick_key'])) {

                $new_key .= '_' . $field_settings['brick_key'];

            }

            // Lets store the new key we have built so far for future needs
            $new_base_key = $new_key;

            // Add the current fields key to complete the new key
            $new_key .= '_' . $fields[$field_key]['key'];

            // Give the field the brand new key
            $fields[$field_key]['key'] = $new_key;

            // Lets keep the array key of any item that we should traverse down.
            $field_settings_rabbit_hole_array_key = $this->get_rabbit_hole_array_key($field_settings);

            // Do we have a key to go down?
            if($field_settings_rabbit_hole_array_key !== false) {

                // Recursion!
                $fields[$field_key][$field_settings_rabbit_hole_array_key] =
                    $this->set_unique_keys($field_settings[$field_settings_rabbit_hole_array_key], $new_key);

            }

            // Lets fix the conditional logic
            if(isset($field_settings['conditional_logic']) && !empty($field_settings['conditional_logic'])) {

                foreach($field_settings['conditional_logic'] AS $lvl_1_key => $lvl_1_value) {

                    foreach($field_settings['conditional_logic'][$lvl_1_key] AS $lvl_2_key => $lvl_2_value) {

                        $fields[$field_key]['conditional_logic'][$lvl_1_key][$lvl_2_key]['field'] =
                            $new_base_key . '_' .
                            $field_settings['conditional_logic'][$lvl_1_key][$lvl_2_key]['field'];

                    }

                }

            }

        }

        return $fields;

    }

    /**
     * @param array $field_settings
     * @return bool|string
     */
    private function get_rabbit_hole_array_key($field_settings)
    {

        // Lets keep the array key of any item that we should traverse down.
        $field_settings_rabbit_hole_array_key = false;

        if (isset($field_settings['fields']) && is_array($field_settings['fields'])) {

            $field_settings_rabbit_hole_array_key = 'fields';

        } elseif (isset($field_settings['sub_fields']) && is_array($field_settings['sub_fields'])) {

            $field_settings_rabbit_hole_array_key = 'sub_fields';

        } elseif (isset($field_settings['layouts']) && is_array($field_settings['layouts'])) {

            $field_settings_rabbit_hole_array_key = 'layouts';

        }

        return $field_settings_rabbit_hole_array_key;

    }

    /**
     * Checks for duplicate keys. This functions hould not be called in a production environment since
     * it will cause wp_die if a duplicate key is found and will also slow down performance by looping lots
     * of multidimensional arrays.
     * @param $fields
     */
    private function check_keys($fields)
    {

        global $debug_keys;

        $error_string = false;
        $name_of_looped_field = false;

        foreach ($fields as $array_key => $value) {

            if (!$error_string && is_array($value)) {
                // If we have not already run into an error and we are dealting with an array

                $this->check_keys($value);

            } elseif ($array_key === 'key') {


                if (array_search($value, $debug_keys) !== false) {
                    // If key already exists

                    $error_string = 'The key <b>' . $value . '</b> already exists.';

                } elseif (substr($value, 0, 1) == '_' || substr($value, -1) == '_') {
                    // If the key starts or ends with an underscore

                    $error_string = 'A key must not start or end with an underscore. You have probably forgotten to set a key somewhere. Key with errors: <b>' . $value . '</b>';

                } else {

                    $debug_keys[] = $value;

                }

            } elseif ($array_key === 'name') {

                $name_of_looped_field = $value;

            }

            if ($error_string !== false && $name_of_looped_field !== false) {
                // If we have an error and have found the name

                $die_string = 'Message from Fewbricks: ';
                $die_string .= 'Fatal error when adding field group "' . $this->settings['title'] . '". ';
                $die_string .= $error_string . ' ';
                $die_string .= 'Please use another key for field "' . $name_of_looped_field . '"';
                wp_die($die_string);

            }

        }

    }

    /**
     * This function hides and/or removes items on the edit screen for where the field group is present.
     * Note that hide and showare mutually exclusive. If you pass anything but false to hide, show will be ignored.
     * Pass (false, []) to apply the values in show.
     * @param bool|array $names_of_items_to_hide
     * @param bool|array $names_of_items_to_show
     * @return array
     */
    private function get_hide_on_screen_settings($names_of_items_to_hide = false, $names_of_items_to_show = false)
    {

        $default_items_to_hide = [
            0 => 'the_content',
            1 => 'excerpt',
            2 => 'custom_fields',
            3 => 'discussion',
            4 => 'comments',
            5 => 'revisions',
            6 => 'slug',
            7 => 'author',
            8 => 'format',
            //9 => 'page_attributes', // Since page attributes are so often shown
            10 => 'featured_image',
            11 => 'categories',
            12 => 'tags',
            13 => 'send-trackbacks',
        ];

        if ($names_of_items_to_hide !== false) {

            foreach ($default_items_to_hide AS $default_item_key => $default_item_name) {

                if (!in_array($default_item_name, $names_of_items_to_hide)) {

                    unset($default_items_to_hide[$default_item_key]);

                }

            }

        } elseif (is_array($names_of_items_to_show)) {

            foreach ($names_of_items_to_show AS $name_of_item_to_show) {

                // Find the key of the item in settings having the value of the key we want to show...
                if (false !== ($item_key = array_search($name_of_item_to_show, $default_items_to_hide))) {

                    // ...and remove that item from our settings array.
                    unset($default_items_to_hide[$item_key]);

                }

            }

        }

        return $default_items_to_hide;

    }

    /**
     * Write settings to json file
     */
    private function save_json()
    {

        acf_write_json_field_group($this->settings);

    }

    /**
     *
     */
    public function print_settings()
    {

        echo '<h3>Field group: ' . $this->settings['title'] . '</h3>';

        echo '<pre>';
        print_r($this->settings);
        echo '</pre>';

    }

}
