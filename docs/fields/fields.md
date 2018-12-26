---
layout: default
title: Fields 
nav_order: 50
has_children: true
permalink: /fields/
---

# Fields
All field types that are available in ACF are available in Fewbricks. With one exception; the field type Clone. 
Check the [FAQ](/faq/) on why.

## Create a field instance
```php
<?php
// (label, name, site wide unique key)
$textField = new Fewbricks\ACF\Fields\Text('A text field', 'text', '1801060035a');
```

## Label
The label to be shown next to the field in the admin area.

## Name
The name by which to fetch the fields data. If adding a field to a flexible content, repeater or brick, the name will
be prepended with the name of the brick. Fewbricks will take care of most of those instances when you are fetching
field data through Fewbricks functions so you can often pass the original field name and the code will make sure you 
get the correct data. If you are having trouble fetching data, enable [dev_tools/show_fields_info]
(/filters/dev_tools--show_fields_info/) to see the name of the field in the admin area when editing a post.

Due to restrictions in the WordPress table structure, the max length of a field name is 255 characters. So if you 
have fields that go a couple of levels deep (for example a brick in a flexible field that have a repeater), the field
 name could potentially exceed that limit. This should be considered whe creating instances of bricks and fields. 
 *Fewbricks takes care of checking that your field name does not exceed the max length and will die if it does. If 
 the value of a field is not saved, the reason is most likely that the name is too long. In which case the only 
 solution is to shorten the field and/or brick names.

## Key
Check the [FAQ](/faq/) for info on the site wide unique keys.

## ACF settings
All settings for fields that are available in ACF is possible to set in Fewbricks. Our goal is to keep Fewbricks' code
up to date with one get- and one set-function for each setting. The way the functions are named follow the same rules
 as described for [Field Groups](/field-groups/#acf-settings) with functions named setSettingsName() and
 getSettingsName().
 
The code does not do any checks to make sure that values being sent to the setter functions are correct. This is since
ACF may suddenly allow for some new value which Fewbricks should accept without the code having to be updated. 

### Quick example

```php
<?php

$textField->setDefaultValue('Some text');
$textField->getMaxLength();

```

## Conditional logic
You apply conditional logic like this:

```php
<?php

$textField
->addConditionalLogicRuleGroup(
(new ConditionalLogicRuleGroup())
    ->addRule(new ConditionalLogicRule('1711192022y', '==', '1'))
    // ...and...
    ->addRule(new ConditionalLogicRule('1711192022z', '==', '2'))
) // ...or...
->addConditionalLogicRuleGroup(
(new ConditionalLogicRuleGroup())
  ->addRule(new ConditionalLogicRule('1711172249u', '==', 'black'))
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
that Fewbricks generated.

## Adding new field types
Read under [Extensions](/fields/extensions/) for info on how to support non-ACF-core fields.
