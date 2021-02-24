---
parent: Fields
layout: default
title: Groups
nav_order: 40
permalink: /fields/groups/
---

# Fields - Groups
{: .no_toc }

## Table of contents
{: .no_toc .text-delta }

- TOC
{:toc}

## Example code
Below you will find some simple demo code to show you how to get started. For a more advanced OOP approach, how to use Bricks for layouts, how to display the data and more tips and tricks check out [The Fewbricks Demo Theme](https://github.com/folbert/fewbricks-demo-theme).


```php
<?php

namespace App\KAN\Fewbricks;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Group;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;

$field_group = new FieldGroup('Demo content', 'demo_content');

$group = (new Group('List items', 'list_items', '2002171553a'))
    ->add_field(new Text('Name', 'name', '2002171553o'))
    ->add_field((
    new Select('Importance', 'importance', '2002171554o'))
        ->set_choices([
                'procrastinable' => 'Procrastinable',
                'important' => 'Important',
                'very_important' => 'Very important',
            ]
        )
        ->set_default_value('procrastinable')
    );

$field_group->add_field($group);

$field_group->add_location_rule_group(
    (new FieldGroupLocationRuleGroup())
        ->add_field_group_location_rule(
            new FieldGroupLocationRule('post_type', '==', 'page')
        )
);

$field_group->register();

```
