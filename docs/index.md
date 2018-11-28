---
layout: default
title: Home 
nav_order: 1
permalink: /
---

November 2018: Please note that Fewbricks2 is very much a work in progress and the documentation will change before the 
first non-beta-release.
{: .label .label-red}

# Fewbricks2

- Gives you a platform for writing code for creating field groups and fields for the awesome WordPress plugin [Advanced 
Custom Fields 
v5 Pro](http://www.advancedcustomfields.com/) or ACF or short.
- Generates the same kind of arrays that are passed to ACFs `acf_add_local_field_group()` when you use "Generate PHP"
 on the ACF Tools screen.
- Allows, but does not force, you to create modules, a.k.a. "Bricks", which can be reused over and over again in 
different field groups, flexible content layouts, other bricks and more.
- Comes with handy features like a basic templating system, which you can replace with your own, in order to keep 
logic and HTML separated.
- Is [available at GitHub](https://github.com/folbert/fewbricks) where [issues](https://github
.com/folbert/fewbricks/issues) can be used to ask questions, report bugs and anything else discussed. Pull requests are welcome.
- Is primarily developed by [Björn Folbert](https://folbert.com), web developer at [KAN](https://kan.se) in Malmö, 
Sweden.

## Quick example
Below is a very simplified example of how you can build field groups and fields in Fewbricks.

### Create some fields

```php
<?php

    $text_field_1 = (new Text('Text field 1', 'text_field_1', '1811262140a'))
        ->setInstructions('Enter something here to reveal another text field');

    $text_field_2 = (new Text('Text field 2', 'text_field_2', '1811262140b'))
        ->addConditionalLogicRuleGroup(
            new ConditionalLogicRuleGroup([ // Only show if field with key 1811262140a is not empty
                new ConditionalLogicRule('1811262140a', '!=', ''),
            ])
        )
        ->setDefaultValue('The man in black fled across the desert');
```

### Create a field group

```php
<?php

    $field_group = (new FieldGroup('Demo field group 1', '1811252128a'))
        ->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup([
                new FieldGroupLocationRule('post_type', '==', 'post'), // When editing posts
            ])), // or
            (new FieldGroupLocationRuleGroup([
                new FieldGroupLocationRule('post_type', '==', 'page'), // When editing a page
                new FieldGroupLocationRule('user_role', '==', 'editor'), // And the user is an editor 
                new FieldGroupLocationRule('page', '==', '3'), // And the id of the page is 3
            ]))
        )
        ->setHideOnScreen('all') // Hide everything that ACF can hide on the screen
        ->setShowOnScreen('permalink') // But show the permalink
        ->addFields([$text_field_1, $text_field_2])
        ->register();

```


## Why does Fewbricks exist?
 
### Portability and re-usability.
Almost all web sites have a couple of building blocks (modules or "bricks") in common. This can, for example, be 
"Page hero", "Plain text", "Image with text to the right", "Image with text to the left", "Image", "YouTube-video"
and so on. Using a module system which is completely built using code and split up into single responsibility files
instead of storing settings in the database as ACF does out of the box, we can reuse the fields holding the code
without setting them up every time we set up a new site. Yes, ACF does come with export functionality and ability to
generate PHP code but it is still, IMHO, cumbersome to cherry-pick bricks for each project.
 
### Flexible ACF.
This is probably the most important, and also the original, reason as to why this system was created. 
Since, in Fewbricks, all ACF-fields are set up using code, we can reuse fields and even other bricks across multiple 
bricks. This means that if we need to have, for example, a button in multiple bricks and places, we can create that 
brick once and then reuse that code all over the place. Now, imagine that the button has multiple settings like  
giving the administrator the ability to select a style and type (internal link, external link, mail, 
download etc.) every time a button is used. Having to set that up in multiple times in ACFs visual editor would be a 
lot of work and you know that the client will want to add new functionality to the button all of a sudden :)

Since development on Fewbricks started, the field "Clone" has been introduced in ACF. While this does solve some of 
the problems that Fewbricks also solves, Fewbricks offers a lot more which you will see later on.

### Extensibility
Since each brick is a class, you can create a new brick based on an existing brick which adds new 
fields and/or its own output. Or you can add code to an existing brick to allow anyone who is creating an instance of
 the class to modify the brick by passing arguments.

### Cleaner way to output HTML
By having each brick output its own HTML, figuring out where to edit the output of the brick becomes a breeze. Even if
 the brick is used in multiple places and loops, the HTML can be edited in one place. Fewbricks encourages you to 
 separate the logic and presentation by supporting automatic loading of view-files.

### Code readability
Easier to see which fields belong to a brick. Instead of having to switch between WP Admin and code to see what you 
named a specific field, you can have it all in one brick class file.

## Legal
Fewbricks is released under GPLv3 and its developers are in no way associated with Advanced Custom Fields. But we are
very grateful to Elliot Condon for creating ACF.
