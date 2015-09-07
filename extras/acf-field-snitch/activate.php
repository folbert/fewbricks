<?php

wp_enqueue_script( 'fewbricks-acf-snitch.js', get_template_directory_uri() . '/fewbricks/extras/acf-field-snitch/snitch.js', ['jquery'], '1.0.0' );

//wp_enqueue_style( 'fewture-admin-css', get_template_directory_uri() . '/fewture/backend/assets/css/admin.css', [], '1.0.0' );
wp_enqueue_style( 'fewture-project-css', get_template_directory_uri() . '/fewbricks/extras/acf-field-snitch/snitch.css', [], '1.0.0' );

