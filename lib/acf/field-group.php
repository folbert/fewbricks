<?php

namespace fewbricks\acf;

use fewbricks\bricks\brick;

// @todo Only if in dev mode
global $debug_keys;
$debug_keys = [];

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
        $this->settings = [
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
     * @param $field
     * @return $this
     */
    public function add_field($field)
    {

        $this->settings['fields'][] = $field->get_settings($this);

        return $this;

    }

    /**
     * @param $brick
     * @return $this
     */
    public function add_brick($brick)
    {

        // Add the fields of the brick to the fields of the brick
        $this->set_setting('fields', array_merge($this->get_setting('fields'), $brick->get_settings($this)['fields']));

        return $this;

    }

    public function add_repeater()
    {

    }

    /**
     * @param \fewbricks\acf\fields\flexible_content $flexible_content
     */
    public function add_flexible_content($flexible_content)
    {

        $this->settings['fields'][] = $flexible_content->get_settings($this);

    }

    /**
     * @param $common_field_name
     * @param $name_prefix
     */
    public function add_common_field($common_field_name, $name_prefix)
    {


    }

    /**
     * Register a field group.
     */
    public function register()
    {

        if (!isset($this->settings['names_of_items_to_hide_on_screen']) && !isset($this->settings['names_of_items_to_show_on_screen'])) {

            $this->settings['hide_on_screen'] = $this->get_hide_on_screen_settings();

        } elseif (isset($this->settings['names_of_items_to_show_on_screen'])) {

            $this->settings['hide_on_screen'] = $this->get_hide_on_screen_settings(false,
                $this->settings['names_of_items_to_show_on_screen']);

        } else {

            $this->settings['hide_on_screen'] = $this->get_hide_on_screen_settings(
                $this->settings['names_of_items_to_hide_on_screen'], false);

        }

        if (FEWBRICKS_DEV_MODE) {

            if (isset($_GET['dumpfewbricksfields'])) {

                $this->print_settings();

            } else {

                $this->check_keys($this->settings['fields']);

            }

        }

        global $fewbricks_save_json;

        if ($fewbricks_save_json === true) {

            $this->save_json();

        }

        register_field_group($this->settings);

    }

    /**
     * Checks for duplicate keys. This functions hould not be called in a production environment since
     * it will cause wp_die if a duplicate key is found and will also slow down performance by looping lots
     * of multidimensional arrays.
     * @param $array
     */
    function check_keys($array)
    {

        global $debug_keys;

        $error_string = false;
        $name_of_looped_field = false;

        foreach ($array as $key => $value) {

            if (!$error_string && is_array($value)) {

                $this->check_keys($value);

            } elseif ($key === 'key') {

                if (array_search($value, $debug_keys) !== false) {
                    // If key already exists

                    $error_string = 'The key <b>' . $value . '</b> already exists.';

                } elseif(substr($value, 0, 1) == '_' || substr($value, -1) == '_') {

                    $error_string = 'A key must not start or end with an underscore. You have probably forgotten to set a key somewhere. Key with errors: <b>' . $value . '</b>';

                } else {

                    $debug_keys[] = $value;

                }

            } elseif($key === 'name') {

                $name_of_looped_field = $value;

            }

            if ($error_string !== false && $name_of_looped_field !== false) {

                $die_string = 'Fatal error when adding field group "' . $this->settings['title'] . '". ';
                $die_string .= $error_string . ' ';
                $die_string .= 'Please use another key for field "' . $name_of_looped_field . '"';
                wp_die($die_string);

            }

        }

    }

    /**
     * Remove and keep are mutually exclusive. If you pass hide, show will be ignored.
     * Pass (false, []) to apply the values in show
     * @param bool $names_of_items_to_hide
     * @param bool $names_of_items_to_show
     * @return array
     * @todo Add description in readme about this feature
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
                if (false !== ($item_key = array_search($keys_of_item_to_show, $default_items_to_hide))) {

                    // ...and remove that item from our settings array.
                    unset($default_items_to_hide[$item_key]);

                }

            }

        }

        return $default_items_to_hide;

    }

    /**
     *
     */
    private function save_json()
    {

        file_put_contents(get_template_directory() . '/acf-json/' . $this->settings['key'] . '.json',
            json_encode($this->settings));

    }

    /**
     *
     */
    public function print_settings()
    {

        echo  '<h3>Field group: ' . $this->settings['title'] . '</h3>';
        \fewture\vd($this->settings);

    }

}