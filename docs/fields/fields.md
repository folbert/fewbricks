---
layout: default
title: Fields 
nav_order: 5
has_children: true
permalink: fields
---

# Fields

All field types that are available in ACF are available in Fewbricks. With one exception; the field type [Clone
(#section-where-s-the-field-type-clone-).

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
field data so you can often pass the original field name and the code will make sure you get the correct data.

Due to restrictions in the WordPress table structure, the max length of a field name is ~64~ 255 characters. So if
you have fields that go a couple of levels deep (for example a brick in a flexible field that have a repeater), you
the field name could potentially exceed that limit. This should be considered whe creating instances of bricks and
fields. If the value of a field is not saved, the reason is most likely that the name is too long. In which case
the only solution is to shorten the field and/or brick names.

## Key
The same rules apply to keys for fields as for [keys for field groups](doc:field-groups#section-a-note-on-keys)

## ACF settings
All settings for fields that are available in ACF is possible to set in Fewbricks. No exceptions here. We try to keep
the code up to date with one get- and one set-function for each setting. Just like [ACF settings for field
groups](doc:field-groups#section-acf-settings), the function name is a camelCase version of the name that the
setting has been given by ACF. So to set the default value and max length of a field that supports it, you would do:

```php
<?php

$textField->setDefaultValue('Some text');
$textField->setMaxLength(10);

// or

(new Fewbricks\ACF\Fields\Text('A text field', 'text', '1801060035a'))
  ->setDefaultValue('Some text')
  ->setMaxlength(10);
```

The easiest way to find the name of a setting is most likely to enable [show_fields_info](doc:show_fields_info) and
head to the ACF GUI to create a field group and then add a field of the field type you are interested in. Each
input for settings will then be accompanied by a yellow label telling you the underscore_name of the setting
"Translate" that into a camelCase version to know the name of the function you want to call.

Fewbricks does not check the values you are trying to set. This means that we do not validate values for settings
that ACF has select boxes for in the GUI. This is to make sure that all new possible values are available to set as
soon as ACF supports them instead of Fewbricks telling you that the value is illegal.

You can also pass an array of settings as the fourth parameter when creating a field instance.

If a new setting is added that Fewbricks has not yet implemented a function for, you can always use the generic 
`setSetting($name, $value)` and simply pass the name of the setting as the first parameter.
{: .fw-700 }

## Conditional logic
You apply conditional logic like this:

```php
<?php

(new Fewbricks\ACF\Fields\Text('A text field', 'text', '1801060035a'))
  ->addConditionalLogicRuleGroup(
    (new ConditionalLogicRuleGroup())
      ->addRule(new ConditionalLogicRule('1711192022y', '==', '1'))
			->addRule(new ConditionalLogicRule('1711192022z', '==', '2'))
  )
  ->addConditionalLogicRuleGroup(
    (new ConditionalLogicRuleGroup())
      ->addRule(new ConditionalLogicRule('1711172249u', '==', 'black'))
  );
```

The relation between rule groups is _or_ and the relation between rules within a group is _and_. So the code above would render a rule that would display the text field:

- The field with the id 1711192022y has a value of 1
  - _and_
- The field with id 1711192022z has a value of 2
_or_
- The field with the id 1711172249u has a value of "black"

## Adding new field types
If you want to add a new field type for an [ACF extension](https://awesomeacf.com/) or if ACF releases a new field
type that Fewbricks does not yet support, you can create a class for that field type yourself and put it in your
custom Fewbricks code directory. Just make sure that the class extends `Fewbricks\ACF\Field` or one of the other
available child classes of Field:

- `Fewbricks\ACF\DateTimeField`
- `Fewbricks\ACF\FieldWithChoices`
- `Fewbricks\ACF\FieldWithFields`
- `Fewbricks\ACF\FieldWithImages`
- `Fewbricks\ACF\FieldWithLayouts`

The easiest way is probably to check out one of the existing field-classes in src\ACF\Fields and take it from there.
Make sure that your class have a function like this:

```php
<?php

public function getType()
{
  // The name of field type that ACF uses.
  return 'field_type_name';
}
```

## Where's the field type "Clone"?
Since Fewbricks gives you means to clone fields and field collections using code, I can not see a case where the
clone field would come in handy. So in order to keep the code as clean as possible and not introduce another way to
almost do what Fewbricks does (better IMHO), I have decided to keep "clone" out of Fewbricks.
