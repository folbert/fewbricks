<?php

/**
 *  My suggestion is that you use this file to require all other set-up-files.
 */

// NOTE:  Dont use require once since that will ruin the admin page displaying stuff for field groups

require('content-page.php');
//require('fewture-options.php');

// Remove the lines below to get rid of demo code.
//require(__DIR__ . '/../demo/field-groups-demo.php');
//require(__DIR__ . '/../demo/field-groups-options.php');