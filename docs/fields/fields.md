---
layout: default
title: Fields
nav_order: 40
has_children: true
permalink: /fields/
---

# Fields

## Example code
The code is written using a minimum of indentation and long lines to allow for reading on small screens.

```php
<?php

namespace FewbricksDemo;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Wysiwyg;

$favourite_character =
(new Select('Who is your favourite character in Star Wars?', 'favourite_character', '1811262140b'))
  ->set_choices([
  'luke' => 'Luke Skywalker',
  'leia' => 'Leia Organa',
  'han' => 'Han Solo',
  'chewie' => 'Chewbacca',
  'other' => 'Other'
])
  ->set_allow_null(false)
  ->set_required(true)

$other_favourite_character = (new Text('My favourite character is none of the above but:', 'other_favourite_character',
'1811262140a'))
  ->add_conditional_logic_rule_group
(
  (new ConditionalLogicRuleGroup())
    ->add_conditional_logic_rule(
      // Only display this field if the field with key "1811262140b" is set to "other".
      new ConditionalLogicRule('1811262140b', '==', 'other')
  )
)
  ->set_required(true)
  ->set_placeholder('Maybe Boba Fett?');

$motivation = (new Wysiwyg('Please motivate', 'motivation', '1811292147a'))
  ->set_instructions('Feel free to add a motivation as to why your favourite characters is the one you stated above.')
  ->set_delay(true)
  ->set_media_upload(false)
  ->set_tabs('visual')
  ->set_wrapper(['id' => 'favourite_character_motivation']);
```

There, now we have three fields. But just having some fields makes no sense in ACF, so if you are curious on how to proceed, check out [Field Groups](/field-groups) but be sure to come back here for more goodies.

## Available field types
All field types that are available in ACF are available in Fewbricks. With one exception; the field type Clone. Check the [FAQ](/faq/#wheres-the-clone-field) to find out why.

## Constructor arguments

`new Field('Label', 'Name', 'Key')`

### Label
The label to be shown next to the field in the admin area.

### Name
The name by which to fetch the fields data. If adding a field to a flexible content, repeater or Brick, the name will be prepended with the name of the brick. Fewbricks will take care of most of those instances when you are fetching field data through Fewbricks functions so you can often pass the original field name and the code will make sure you get the correct data. If you are having trouble fetching data, use the filter [fewbricks/show_fields_info](/filters/#fewbricksshow_fields_info) to see the name of the field in the admin area when editing a post.

Due to restrictions in the WordPress table structure, the max length of a field name is 255 characters. So if you have fields that go a couple of levels deep (for example a brick in a flexible field that have a repeater), the field name could potentially exceed that limit. This should be considered when creating instances of bricks and fields. If [dev-mode](/dev-mode) is enabled, Fewbricks takes care of checking that your field name does not exceed the max length and will die if it does. If the value of a field is not saved, the reason is most likely that the name is too long. In which case the only  solution is to shorten the field and/or brick names.

### Key
Check the [FAQ](/faq/) for info on the site wide unique keys.

## ACF settings
In the field classes we have implemented getters and setters for all the ACF settings that are available at the time of writing this (ACF v.5.7.7). You can also use the generic functions `set_setting()` and `get_setting()` to set and get any new settings that ACF introduces without having to wait for Fewbricks to be updated with new getters and setters. This also applies to settings that are introduced by any extension that you install. Yes, you can use those generic functions instead of Fewbricks settings-specific functions as well if you want, but having for example `set_label_placement()` popping up if your editor has intelligent code completion is way easier than having to remember every settings name like in Fewbricks 1 which mainly used associative arrays.

The function names are made up of ACFs snake_case_names. So for example the setting "label_placement" is set by calling `set_label_placement('value')` and "Description" is set by `set_description('Just do it!')`. Most of the times you will be able to figure out the name that ACF stores a setting under by looking at the english label in ACFs GUI when creating a field group. For example "Required" is stored as "required" which in turn can be set in Fewbricks by calling `set_required(true)` (or `set_required(false)`). There are however some cases where the label does not directly corresponds to you what the ACF setting is called. An example of this is "Order" which ACF stores as "menu_order" which in turn corresponds to `set_menu_order()` in Fewbricks. The easiest way to find out what the setting is called is by using the filter [fewbricks/show_fields_info](/filters/#fewbricksshow_fields_info) to display each setting fields name in the ACF GUI.

Fewbricks does not check to make sure that values being sent to the setter functions are correct. This is since ACF may suddenly allow for some new value which Fewbricks should then accept without the code having to be updated.

### Quick example

```php
<?php
$text_field = new Text('The text', 'the_text', '2002142238a');
$text_field->set_default_value('Some text');
$text_field->set_max_length(200);

$text_field->get_max_length(200);

```

You can also use chaining like so:

```php
<?php
$text_field = (new Text('The text', 'the_text', '2002142238a'))
->set_default_value('Some text')
->set_max_length(200);

```

## Conditional logic
You apply conditional logic like this:

```php
<?php

$textField
->add_conditional_logic_rule_group(
(new ConditionalLogicRuleGroup())
    ->add_rule(new ConditionalLogicRule('1711192022y', '==', '1'))
    // ...and...
    ->add_rule(new ConditionalLogicRule('1711192022z', '==', '2'))
) // ...or...
->add_conditional_logic_rule_group(
(new ConditionalLogicRuleGroup())
  ->add_rule(new ConditionalLogicRule('1711172249u', '==', 'black'))
);
```

The relation between rule groups is _or_ and the relation between rules within a group is _and_. So the code above
would render a rule that would display the text field if:

- The field with the id 1711192022y has a value of 1
  - _and_
- The field with id 1711192022z has a value of 2
_or_
- The field with the id 1711172249u has a value of "black"

Even if Fewbricks adds to the key that you give a field you should always use the key that you set and not the one
that Fewbricks generated. Fewbricks will then take care of creating the correct rule based on the key.

## Adding new field types
Read under [Extensions](/fields/extensions/) for info on how to support non-ACF-core fields.
