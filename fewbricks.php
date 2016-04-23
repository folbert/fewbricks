<?php

/*
Plugin Name: Fewbricks
Plugin URI: https://github.com/fewagency/fewbricks
Description: A module extension to Advanced Custom Fields
Author: Björn Folbert
Version: 1.0
Author URI: http://folbert.com
License: GPLv3
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

require_once(plugin_dir_path(__FILE__) . 'lib/fewbricks.php');

fewbricks\fewbricks::construct();