---
layout: default
title: Field Groups 
nav_order: 4
permalink: /field-groups
---

# Field Groups

## Example code
Let's dive right in to some code and create an empty field group by using some inline code. Note that we are using
chaining/fluent notation but you can just as well use the more standard way of creating variables and working with
them.

```php
<?php

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Rule;

(new FieldGroup('Demo field group 1', '1801042233a'))

  // Set where the field group should be visible
  ->addLocationRuleGroup(
    // Display if post type is 'fewbricks_demo_pg' and the post id is 747...
    (new FieldGroupLocationRuleGroup())
      ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg'))
      ->addRule(new Rule('post', '==', '747'))
  )
  ->addLocationRuleGroup(
    // ...or if post type is 'fewbricks_demo_pg2'
    (new FieldGroupLocationRuleGroup())
      ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg2'))
  )
    
  // Hide everything that ACF can hide on the edit screen
  ->setHideOnScreen('all')
    
  // ... but show the permalink
  ->setShowOnScreen('permalink')
    
  // Show the field group at the top
  ->setMenuOrder(1)
    
  // You can also set any ACF setting by using this generic function
  ->setSetting('position', 'side')
    
  // Pass arbitrary arguments. Makes no sense when dealing with FieldGroup
  // directly but if you have created a class for a field group, this can
  // be a great way to tell the instance how to behave.
  ->setArgument('argument_name', 'argument_value')
  ->setArguments([
    'another_argument_name' => 'another_argument_value',
    'yet_another_argument_name' => 'yet_another_argument_value',
  ])
    
  // Finally, register the field group
  ->register();
```

In most cases, `addField()`, `addFields()` and `addBrick()` (which we will talk more about in general in the
[Bricks-section](doc:bricks) ) will probably do what you need.

Note the function `addFieldSetting()` which allows you to set ACF settings on fields through the Field Group. This
will probably only be used in edge cases but may nevertheless be good to know about.

Pro-tip: since the classes for Field Groups, [Bricks](doc:bricks) and [Shared Fields](doc:shared-fields) all extends
the class FieldCollection, all the ways to add fields shown above can be done when dealing with instances of those
classes.
