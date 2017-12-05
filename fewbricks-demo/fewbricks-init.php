<?php

/**
 * This is the file that should start your custom implementation of Fewbricks. Theres abslutely no need for you to
 * follow the same structure that this file has.
 */

// Have this filter return false or remove the line completely to deactivate
// Field Snitch which in turn will display info about the fields in the backend.
add_filter('fewbricks/activate_field_snitch', '__return_true');

// Remove this to remove all demo related stuff
require_once __DIR__ . '/demo/demo-functions.php';

