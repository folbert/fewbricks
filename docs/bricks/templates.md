---
parent: Bricks
layout: default
title: Templates 
nav_order: 1
permalink: /bricks/templates/
---

# Bricks - Templates
Fewbricks come with a very simple templating system which basically passes a bricks collected data to a PHP-file and,
 using output buffering, generates the HTML from the PHP-file. Since the templating system is completely disconnected 
 from bricks, you should be able to create your own or hook in to an existing template engine of your own choice.
 
The documentation below only applies if you want to use the built in BrickTemplater-class.

## Brick template vs brick layouts 
The difference between a brick template and brick layouts is that there can only be one template file per brick and 
it should be responsible for outputting what the Brick is intended for. Layouts can then be used to wrap the template
HTML as needed in the specific instance where the brick is used.

For example for a headline brick, a simplified template may look something like this (in the real world you would
probably apply some CSS-classes to it as well):

```php
<h<?php echo $data['level']; ?><?php echo $data['text']; ?></h<?php echo $data['level'] ?>>
```

Note that we use an associative array called `$data`. This, along with `$brick` which is the brick instance for which
 we are creating HTML, is passed to every template. You also get `$settings` which is an associative array 
 of data that can be sent to BrickTemplater when instantiating it.

You could then have a template like this:

```php
<div class="col"><?php echo $html; ?></div>
```

and another template:

```php
<div class="row"><?php echo $html; ?></div>
```

...and a third template:

```php
<div class="container<?php echo ($settings['fluid'] ? '-fluid' : ''); ?>"><?php echo $html; ?></div>
```

Note that we are using `$html`in each of the layouts. For the first layout, this variable contains the HTML that 
was generated by the template file. For each subsequent layout, it holds the HTML generated by the previous layout. 
So the second layout will get the col-div and the third layout will get the row-div. Layouts are executed in the 
order they were added. As in the template, you also get `$settings` which is the same as was sent to templates.

## Required functions in brick classes

### getViewData()
Must return an associative array with data to be used in the template and layouts.

## Brick Template
One template file per Brick class. 

See the filters [`templater/brick_templates_base_path`](/filters/templater--brick-templates-base-path) and 
[`templater/brick_templates_base_path`](/filters/templater--brick-templates-base-path) for info on how to setup the 
brick templater.

## Layouts
Code wrapping the code generated in the template

See the filter [`templater/brick_layouts_base_path`](/filters/templater--brick-layouts-base-path)for info on how to setup the 
brick templater for layouts.