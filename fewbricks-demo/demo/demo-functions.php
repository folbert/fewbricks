<?php

/**
 * This file contains code that could be put directly in your themes functions.php-file but I strongly suggest you
 * put it in a dedicated file for setting up Fewbricks or even better in a class.
 */

namespace App\FewbricksDemo;

// Moved setup to own file to keep this one as clean as possible to try to mimic a real project

use App\FewbricksDemo\FieldGroups\FieldsKitchenSink;

require_once 'demo-setup.php';

Filters::defineHooks();

(new FieldsKitchenSink('1712042021a'))->register();
