<?php

namespace fewbricks\acf_field_snitch;

add_action('admin_enqueue_scripts' , __NAMESPACE__ . '\\scripts_and_styles');

function scripts_and_styles() {

    wp_enqueue_script( 'fewbricks-acf-snitch.js', plugins_url() . '/fewbricks/extras/acf-field-snitch/snitch.js', ['jquery'], '1.0.0' );
    wp_enqueue_style( 'fewture-project-css', plugins_url() . '/fewbricks/extras/acf-field-snitch/snitch.css', [], '1.0.0' );

}
