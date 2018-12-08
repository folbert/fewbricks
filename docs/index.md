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

## In short, Fewbricks...
- ...is a framework allowing you to write code to create field groups, fields and reusable field collections, 
Bricks, for the awesome WordPress plugin [Advanced Custom Fields v5 Pro](http://www.advancedcustomfields.com/) or ACF
 for short.
- ...generates the same kind of arrays that are passed to ACFs `acf_add_local_field_group()` when you use "Generate PHP"
 on the ACF Tools screen. So, sorry to disappoint, there's no black magic in Fewbricks.
- ...allows, but does not force, you to create field collections, a.k.a. "Bricks", which can be reused over and over 
again in different field groups, flexible content layouts, other bricks and more.
- ...comes with a basic template engine in order to keep logic and output separated. The template engine can easily
 be replaced or extended.
- ...is [available at GitHub](https://github.com/folbert/fewbricks) where [issues](https://github
.com/folbert/fewbricks/issues) can be used to ask questions, report bugs and anything else discussed. Pull requests are welcome.
- ...is primarily developed by [Björn Folbert](https://folbert.com), web developer at [KAN](https://kan.se) in Malmö, 
Sweden.

## Quick example
Below is a very simplified example of how you can build Bricks, fields and field groups using Fewbricks. For 
more detailed info on everything like how to use an OOP approach and to see the power of Bricks, please see the 
corresponding items in the menu.

For an extensive collection of demo code, please see
[https://github.com/folbert/fewbricks/tree/2.x/demo](https://github.com/folbert/fewbricks/tree/2.x/demo).

### Create a Brick
{: .no_toc }
You don't have to use Bricks when using Fewbricks but it is, in our humble opinion, one of Fewbricks greatest features.
 So let's start by showing them off. Simply put, Bricks are reusable collections of fields. A Brick can include or 
 extend other Bricks and you have a lot of functions available to change Bricks on the fly.
 
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
    public function setup()
    {
        
        $text = (new Text('Text', 'the_text', '1811292152a'))
            ->setRequired(true);

        $image = (new Image('Image', 'image', '1811272243a'))
            ->setRequired(true)
            ->setMinWidth(400)->setMinHeight(400)
            ->setMaxWidth(1200)->setMaxHeight(1200);

        // Add fields to the Brick
        $this->addFields([$text, $image]);

    }

    /**
     * If you are using Fewbricks built-in template engine, the Brick must have 
     * a function called getViewData which returns an associative array with data from each field. 
     * @return array
     */
    public function getViewData()
    {

        // getFieldValues is a Fewbricks function allowing you to pass multiple field names and get an
        // associative array with the values of each field in return.
        return $this->getFieldValues(['text', 'image']);

    }

}
```

### Create fields
{: .no_toc }
Now, let's create some free wheeling fields outside any class. Just to show you that you can create fields without 
using Bricks or implementing an OOP approach.

I have deliberately not indented the chained function calls in order to increase readability on small screens. 

```php
<?php

namespace FewbricksDemo;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Wysiwyg;

$favouriteCharacter = (new Select('Who is your favourite character?', 'favourite_character', '1811262140b'))
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

$otherFavouriteCharacter = (new Text('My favourite character is none of the above but:', 'other_favourite_character',
'1811262140a'))
->addConditionalLogicRuleGroup
(
    (new ConditionalLogicRuleGroup())
        ->addConditionalLogicRule(
            // Only display this field if the field with key "1811262140b" is set to "other".
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

### Create a field group and add our Brick and fields to it
{: .no_toc }

```php
<?php

namespace FewbricksDemo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Email;
use FewbricksDemo\Bricks\ImageAndText;

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
->addField($favouriteCharacter)
// ...add multiple fields.
->addFields([
    $otherFavouriteCharacter,
    $motivation,
    // Create an inline field
    (new Email('Enter your e-mail for a chance to win!', 'e_mail', '1811281100a'))
        ->setRequired(true)
])
->addBrick((new ImageAndText('image_and_name', '1811290826a')))
// Finish up by registering the field group to ACF.
->register();

```

## Main concepts
 
### Portability and re-usability
{: .no_toc }
Almost all web sites have a couple of building blocks (modules or "bricks") in common. This can, for example, be 
"Page hero", "Plain text", "Image with text to the right", "Image with text to the left", "Image", "YouTube-video"
and so on. Using a modular system which is completely built using code and split up into single responsibility files
instead of storing settings in the database as ACF does out of the box, we simplify reusing field groups, 
fields and bricks across WordPress installs. Yes, ACF does come with export functionality and ability to generate PHP 
code but it is still, in our humble opinion, cumbersome to cherry-pick bricks for each project.
 
### Flexible ACF
{: .no_toc }
This is probably the most important, and also the original, reason as to why this system was created. Since, in 
Fewbricks, all ACF-fields are set up using code, we can reuse fields and even other bricks across multiple bricks.  
This means that if we need to have, for example, a button in multiple bricks and places, we can create that brick 
once and then reuse that code all over the place. Now, imagine that the button has multiple settings like giving the 
administrator the ability to select a style and type (internal link, external link, mail, download etc.) every time 
a button is used. Having to set that up in multiple times in ACFs visual editor would be a lot of work and you know 
that the client will want to add new functionality to the button all of a sudden :) Using Fewbricks, all you have to 
do is change the code in one place. You can even use any of Fewbricks many functions for interacting with Bricks to 
set up the button brick to behave differently depending on where it is implemented. 

Since development on Fewbricks started, the field "Clone" has been introduced in ACF. While this does solve some of 
the problems that Fewbricks also solves, Fewbricks offers a lot more which you will see later on.

### Extensibility
{: .no_toc }
Since each Brick is a class, you can create a new Brick based on an existing Brick which adds new fields and/or its 
own output. Or you can add code to an existing Brick to allow anyone who is creating an instance of the class to 
modify the Brick by passing arguments.

### Cleaner way to output HTML
{: .no_toc }
By having one template file for each Brick, figuring out where to edit the output of the brick becomes a breeze. Even if
 the brick is used in multiple places and loops, the HTML can be edited in one place. Fewbricks encourages you to 
 separate the logic and presentation by giving you access with a light weight template engine which you can replace 
 or extend if needed.

### Code readability
{: .no_toc }
Easier to see which fields belong to a Brick. Instead of having to switch between WordPress Admin and code to see what 
you named a specific field when you want to use it, you can have it all in one brick class file.

## Legal
Fewbricks is released under GPLv3 and its developers are not associated with Advanced Custom Fields. But we are
very grateful to Elliot Condon for creating it.
