---
layout: default
title: Bricks
nav_order: 45
has_children: true
permalink: /bricks/
---

# Bricks

## Create a Brick
You don't have to use Bricks when using Fewbricks but it is, in my humble opinion, one of Fewbricks greatest features. Simply put, a Brick is a reusable collections of fields. A Brick can include or extend other Bricks and you have a lot of functions available to change Bricks on the fly.

Just like fields, Bricks will not show up in WordPress unless they are added to a field group. That will be done
later on in this example.

```php
<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\Fields\Image;
use Fewbricks\ACF\Fields\Text;

class ImageAndText extends Brick
{

    /**
     * Set the fields that the Brick is made up of.
     * The setup function is automatically called by the parent Brick class.
     */
    public function set_up()
    {

        $text = (new Text('Text', 'the_text', '1811292152a'))
            ->set_required(true);

        $image = (new Image('Image', 'image', '1811272243a'))
            ->set_required(true)
            ->set_min_width(400)->set_min_height(400)
            ->set_max_width(1200)->set_max_height(1200);

        // Add fields to the Brick
        $this->add_fields([$text, $image]);

    }

    /**
     * Example function for getting view data for the Brick. This can of course be much more advanced using
     * custom logic to alter the return values.
     */
    public function get_view_data()
    {

        // get_field_values is a Fewbricks function allowing you to pass multiple field names and get an
        // associative array with the values of each field in return.
        return $this->get_field_values(['text', 'image']);

    }

}
```

When added to a field group or another brick, bricks are just a collection of fields which will be added just like
they would if you used `add_field()` or `add_fields()`.

## Templates

## get_brick_html()
If you want to use

## getHtml()

## set_up() called on every instance
