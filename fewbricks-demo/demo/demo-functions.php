<?php

/**
 * This file contains code that could be put directly in your themes functions.php-file but I strongly suggest you
 * put it in a dedicated file for setting up Fewbricks or even better in a class.
 */

namespace App\FewbricksDemo;

use App\FewbricksDemo\FieldGroups\FieldsKitchenSink;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Rule;

// The setup file deals with demo specific functionality so it was moved to own file to keep this file as focused on
// Fewbricks as possible.
require_once 'demo-setup.php';

Filters::defineHooks();

// Demoing a class
(new FieldsKitchenSink('1712042021a'))
    ->setTitle('Main content')
    ->register();

// Demoing the same class but but changing it on the fly
(new FieldsKitchenSink('17120529561a'))
    ->clearLocationRuleGroups()
    ->addLocationRuleGroups([
        (new FieldGroupLocationRuleGroup())->addRule(
            new Rule('post_type', '=', 'fewbricks_demo_pg2')
        ),
        (new FieldGroupLocationRuleGroup())->addRule(
            new Rule('post_type', '=', 'fewbricks_demo_pg')
        ),
    ])
    ->setTitle('Secondary content')
    ->hideOnScreen('the_content')
    ->setFieldNamesPrefix('secondary_content_')
    ->register();
