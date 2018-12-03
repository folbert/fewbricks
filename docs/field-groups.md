---
layout: default
title: Field Groups 
nav_order: 40
permalink: /field-groups/
---

# Field Groups
Every field in ACF (and therefore also Fewbricks) must belong to a field group. 

Note that you should strive to use the action 'fewbricks/init' to start off all your Fewbricks related code. This way
 you can be sure that ACF and Fewbricks is ready. If you, for some reason, can not use that action, you will most 
 likely be ok anyway.

## Quick example

```php
<?php

add_action('fewbricks/init', function() {
    
// Instantiate a field group with a title and a key. More on keys below. 
$dark_tower_contest_field_group = (new FieldGroup('Dark Tower Contest', '1811252128a'))
// Tell the field group where it should show up
->addLocationRuleGroup( 
    (new FieldGroupLocationRuleGroup())
        ->addFieldGroupLocationRule(
            // When editing a post
            new FieldGroupLocationRule('post_type', '==', 'post')
        )
) // ...or ...
->addLocationRuleGroup(
    (new FieldGroupLocationRuleGroup())
        ->addFieldGroupLocationRule(
            // ...when editing a page...
            new FieldGroupLocationRule('post_type', '==', 'page')
        )
        ->addFieldGroupLocationRule(
            // ...and the user is an editor.
            new FieldGroupLocationRule('user_role', '==', 'editor')
        )
)
// Read more about this under Dev Tools
->setShowInFewbricksDevTools(true)
// Hide everything that ACF can hide
->setHideOnScreen('all')
// Assuming we have some fields stored in variables. See under Fields for more info
->addField($some_field)
->addFields([
    $some_other_field,
    $yet_another_field,
    // Creating a field on the fly
    (new \Fewbricks\ACF\Fields\Text('A text field', 'a_text_field', '1811302037a'))
])
// Adding a Brick. Read more about those under Bricks.
->addBrick(new \FewbricksDemo\Bricks\ImageAndText('image_and_text', '1811392037o'))
// ...but show permalink
->setShowOnScreen('permalink');
    
});
    
```

We have to hold off registering the field group until we have added some fields (which could have been done by 
chaining the functions for adding fields etc. but for the sake of having code for fields on its own documentation 
pages, we save that for later). When it's time to register, you simply call the function `register()` on the field 
group like so:

```php
<?php

$dark_tower_contest_field_group->register();

```

In the example above, we have created a field group with just a couple of lines of code. Since FieldGroup is a class 
in Fewbricks, you could create your own field group classes and have them extend FieldGroup like so:

```php
<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use FewbricksDemo\Bricks\Headline;

class FooterGlobalTexts extends FieldGroup
{

    public function setup()
    {

        $this->addBrick(
            (new Headline('column_1_headline', '1811292314a'))
            ->addArgument('label', 'Column 1 Headline')
        );

        $this->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('options_page', '==', 'fewbricks-demo-options--global-texts')
            )
        );

        $this->setMenuOrder(20)
            ->setShowInFewbricksDevTools(true)
            ->setStyle('seamless')
            ->register();

    }

}

```

Then you could create and register the field group by calling `(new FooterGlobalTexts('Global texts', '1812010004a'')
->setup()`.

## Keys
The second argument when creating a field group is a key that must be unique across the site. Check [the FAQ](/faq/) 
for more on keys.

## ACF settings
In Fewbricks FieldGroup class we have implemented getters and setters for all the ACF settings that are available at the
time of writing this (ACF v.5.7.7). You can also use the generic functions `setSetting()` and `getSetting()` to set 
and get any new settings that ACF introduces without having to wait for Fewbricks to be updated with new getters and 
setters. This also applies to settings that are introduced by any extension that you install. Yes, you can use those 
generic functions instead of Fewbricks settings-specific functions as well if you want but having for example 
`setLabelPlacement()` popping up if your editor handles auto complete is way easier than having to remember every 
settings name like in Fewbricks 1.
 
The function names are camelCaseVersions of ACFs snake_case_names. So for example the setting "label_placement" is 
set by calling `setLabelPlacement('value')` and "Description" is set by `setDescription()`. Most of the times you will
be able to calculate the name that ACF stores a setting under by looking at the (english) label in ACFs GUI when 
creating a field group. For example "Active" is stored under "active" which in turn can be set in Fewbricks by 
calling `setActive(true)` (or `setActive(false)`). There are however some cases where the label does not directly 
corresponds to you what the ACF setting is called. An example of this is "Order" which ACF stores as "menu_order" 
which corresponds to `setMenuOrder()` in Fewbricks. The easiest way to find out what the setting is called is by 
using the filter [fewbricks/dev_tools/show_fields_info](/filters/dev_tools--show_fields_info/). This will display what 
each setting is actually stored as by ACF.

## Fewbricks functions
Besides setting and getting all the ACF settings, the following functions are available for you to interact with field 
groups. For info on which arguments to pass to each function, please refer to each functions docblock or body in the 
code.

`addBrick()` and `addBricks()` - read more about Bricks under [Bricks](/bricks/).

`addField()` and `addFields` - add fields to the field group. More on that under [Fields](/fields/).

`addBrickBeforeByName()` and `addBrickAfterFieldByName()` - add a Brick before/after an existing field by sending 
the name of the field to add before/after.

`addBrickToBeginning()`

`addFieldToBeginning()` and `addFieldsToBeginning()`

`addFieldAfterFieldByName()`, `addFieldsAfterFieldByName()`, `addFieldBeforeFieldByName()` and 
`addFieldsBeforeFieldByName()` - same as above but add field/fields instead of Bricks.

`removeBrickByKey()` and `removeBrickByName()` - remove all fields that were added to a field group from a brick.

`removeFieldsByKey()`, `removeFieldByKey()`, `removeFieldByName()` and `removeFieldsByName()` - remove fields

`replaceFieldByKey()` and `replaceFieldByName()` - replace existing field.

`addArguments()` and `addArgument()` - add arbitrary arguments that you can use if you for example are using classes 
to extend Fewbricks FieldGroup class.

`getArgument()` - retrieve an argument previously added to the field group.

`getFields()` - get all the fields that has been added to the field group.

`getFieldByName()` - get a field by the name of the field.

`setFieldLabelsPrefix()` - send a string to prefix the labels of all the fields in the group with.

`setFieldNamesPrefix()` - send a string to prefix the names of all the fields in the group with. 

`clearLocationRuleGroups()` - remove all location rules that have been set on the field group.

`setShowInFewbricksDevTools()` - have info about the field group show up in [Fewbricks Dev Tools](/dev-tools/). Check
 the link to find out how to enable the dev tools.
 
`setTitle()` - change the title of the field group.
