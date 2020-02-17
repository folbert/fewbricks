---
parent: Fields
layout: default
title: Flexible Content
nav_order: 20
permalink: /fields/flexible-content/
---

# Fields - Flexible Content
{: .no_toc }

## Table of contents
{: .no_toc .text-delta }

- TOC
{:toc}

## Example code
Below you will find some simple demo code to show you how to get started. For a more advanced OOP approach, how to use Bricks for layouts, how to display the data and more tips and tricks check out [The Fewbricks Demo Theme](https://github.com/folbert/fewbricks-demo-theme).


```php
<?php

namespace FewbricksDemo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\FlexibleContent;
use Fewbricks\ACF\Fields\Image;
use Fewbricks\ACF\Fields\Layout;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Wysiwyg;

$field_group = new FieldGroup('Demo content', 'demo_content');

$flexible_content = new FlexibleContent('Modules', 'modules', '1911292133a');

$text_and_img_layout = new Layout('Text and image', 'text_and_image', '2002171532a');
$text_and_img_layout->add_field(new Text('The text', 'the_text', '2002171533p'));
$text_and_img_layout->add_field(new Image('The image', 'the_image', '2002171533y'));
$flexible_content->add_layout($text_and_img_layout);

$wysiwyg_layout = new Layout('WYSIWYG', 'wysiwyg', '2002171532y');
$wysiwyg_layout->add_field(new Wysiwyg('Content', 'the_content', '2002171539r'));
$flexible_content->add_layout($wysiwyg_layout);

// ... and so on
// But you could also define the fields of each layout in a class as a Brick and then simply do
// $layout = new Layout('...');
// $layout->add_brick(new TextAndImage('text_and_image', '2002171550a'));
// $flexible_content->add_layout($layout);

$flexible_content->set_button_label('Add module');

$field_group->add_field($flexible_content);

$field_group->add_location_rule_group(
    (new FieldGroupLocationRuleGroup())
        ->add_field_group_location_rule(
            new FieldGroupLocationRule('post_type', '==', 'page')
        )
);

$field_group->register();


```
