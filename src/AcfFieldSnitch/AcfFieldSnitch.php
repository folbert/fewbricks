<?php

namespace Fewbricks\AcfFieldSnitch;

/**
 * Class AcfFieldSnitch
 *
 * @package Fewbricks\AcfFieldSnitch
 */
class AcfFieldSnitch
{

    /**
     *
     */
    public static function init()
    {

        add_action('admin_enqueue_scripts', function () {

            if(apply_filters('fewbricks/show_fields_info', false)) {

                $baseUrl = plugins_url() . '/fewbricks/src/AcfFieldSnitch/';

                wp_enqueue_script('fewbricks-acf-field-snitch',
                    $baseUrl . 'snitch.js',
                    ['jquery'], '1.0.0');

                wp_enqueue_style('fewbricks-acf-field-snitch',
                    $baseUrl . 'snitch.css',
                    [],
                    '1.0.0');

            }

        });

    }

}
