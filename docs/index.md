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
{: .no_toc }

- TOC
{:toc}

## In short
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
Below is a very simplified example of how you can build field groups and fields in Fewbricks. For more detailed info on 
everything like how you use an OOP approach and wht you can do with Bricks, please see the corresponding items in the 
menu.

For an extensive collection of demo code, please see
[https://github.com/folbert/fewbricks/tree/fewbricks2/demo](https://github.com/folbert/fewbricks/tree/fewbricks2/demo).

To allow better readability on smaller screens, I have not indented the chained functions. This also avoids the tab 
vs. spaces debate :)

### Create some fields
{: .no_toc }

```php
<?php

// Not including namespaces to save some space in the demo code
// but most classes resides under Fewbricks\ACF\

$favourite_character = (new Select('Who is your favourite character?', 'favourite_character', '1811262140b'))
->setChoices([
    'roland' => 'Roland Deschain',
    'jake' => 'Jake Chambers',
    'susan' => 'Susan Delgado',
    'eddie' => 'Eddie Dean',
    'oy' => 'Oy',
    'other' => 'Other',
])
->setAllowNull(false)
->setRequired(true)
// Fewbricks feature allowing you to prefix the label.
->prefixLabel('Please answer this question: ');

$other_favourite_character = (new Text('My favourite character is none of the above but:', 'other_favourite_character',
'1811262140a'))
->addConditionalLogicRuleGroup
(
    (new ConditionalLogicRuleGroup())
        ->addConditionalLogicRule(
            // Onlu dusplay this field if the field with key "1811262140b" is set to "other".
            new ConditionalLogicRule('1811262140b', '==', 'other')
        )
)
->setRequired(true)
->setPlaceholder('Maybe Randall Flagg?');

$motivation = (new Wysiwyg('Please motivate', 'motivation', '1811292147a'))
->setInstructions('Feel free to add a motivation as to why your favourite characters is the one you stated above.')
->setDelay(true)
->setMediaUpload(false)
->setTabs('visual')
->setWrapper(['id' => 'favourite_character_motivation']);
```

### Create a field group and add fields to it
{: .no_toc }

```php
<?php

(new FieldGroup('Main content', '1811252128a'))
// Tell the field group when it should show up
->addLocationRuleGroup(
    (new FieldGroupLocationRuleGroup())
        ->addFieldGroupLocationRule(
        // When editing a post
            new FieldGroupLocationRule('post_type', '==', 'post')
        )
)
// Hide everything on screen that ACF can hide...
->setHideOnScreen('all')
// ...but show the permalink
->setShowOnScreen('permalink')
// Add a single field or...
->addField($favourite_character)
// ...add multiple fields.
->addFields([
    $other_favourite_character,
    $motivation,
    // Create an inline field
    (new Email('Enter your e-mail for a chance to win!', 'e_mail', '1811281100a'))
        ->setRequired(true)
])
// What's a brick you wonder? Read under Bricks for more info
->addBrick(
    (new ImageAndText('image_and_name', '1811290826a'))
        ->addArgument('text_label', 'Name')
        ->addArgument('text_name', 'name')
)
// Finish up by registering the field group to ACF.
->register();

```

## Main concepts
 
### Portability and re-usability
{: .no_toc }
Almost all web sites have a couple of building blocks (modules or "bricks") in common. This can, for example, be 
"Page hero", "Plain text", "Image with text to the right", "Image with text to the left", "Image", "YouTube-video"
and so on. Using a module system which is completely built using code and split up into single responsibility files
instead of storing settings in the database as ACF does out of the box, we can reuse the fields holding the code
without setting them up every time we set up a new site. Yes, ACF does come with export functionality and ability to
generate PHP code but it is still, IMHO, cumbersome to cherry-pick bricks for each project.
 
### Flexible ACF
{: .no_toc }
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
{: .no_toc }
Since each brick is a class, you can create a new brick based on an existing brick which adds new 
fields and/or its own output. Or you can add code to an existing brick to allow anyone who is creating an instance of
 the class to modify the brick by passing arguments.

### Cleaner way to output HTML
{: .no_toc }
By having each brick output its own HTML, figuring out where to edit the output of the brick becomes a breeze. Even if
 the brick is used in multiple places and loops, the HTML can be edited in one place. Fewbricks encourages you to 
 separate the logic and presentation by supporting automatic loading of view-files.

### Code readability
{: .no_toc }
Easier to see which fields belong to a brick. Instead of having to switch between WP Admin and code to see what you 
named a specific field, you can have it all in one brick class file.

## Legal
Fewbricks is released under GPLv3 and its developers are not associated with Advanced Custom Fields. But we are
very grateful to Elliot Condon for creating it.
