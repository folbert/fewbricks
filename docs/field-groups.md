---
layout: default
title: Field Groups
nav_order: 50
permalink: /field-groups/
---

# Field Groups
Every field in ACF (and therefore also Fewbricks) must belong to a field group.

Note that you should strive to use the action 'fewbricks/init' to start off all your Fewbricks related code. This way
 you can be sure that ACF and Fewbricks is ready. If you, for some reason, can not use that action, you will most
 likely be ok anyway.

## Example code
The code below assumes that you have written the code in [Fields](/fields#example-code) and have access to the variables created there.

```php
<?php

namespace FewbricksDemo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Email;
use FewbricksDemo\Bricks\ImageAndText;

(new FieldGroup('Main content', '1811252128a'))
  ->add_location_rule_group(
    (new FieldGroupLocationRuleGroup())
        ->add_field_group_location_rule(
            new FieldGroupLocationRule('post_type', '==', 'post')
        )
  )
  ->set_hide_on_screen('all')
  ->set_show_on_screen('permalink')
  ->add_field($favourite_character) // Add a single field or...
  ->add_fields([ // ...add multiple fields.
    $other_favourite_character,
    $motivation,
    // Create an inline field
    (new Email('Enter your e-mail for a chance to win!', 'e_mail', '1811281100a'))
        ->set_required(true)
  ])
->register();
```

In the example above, we have created a field group with just a couple of lines of code. Since FieldGroup is a class
in Fewbricks, you could create your own field group classes and have them extend FieldGroup like so:

```php
<?php

namespace FewbricksDemo\FieldGroups;

use Fewbricks\ACF\Text;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;

class Content extends FieldGroup
{

    public function set_up()
    {

        $this->add_field(
            (new Text('Headline', 'column_1_headline', '1811292314a'))
        );

        $this->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
            ->add_field_group_location_rule(
                new FieldGroupLocationRule('post_type', '==', 'page')
            )
            ->add_field_group_location_rule(
                new FieldGroupLocationRule('post_type', '==', 'post')
            )
        );

        $this->set_menu_order(20)
            ->set_show_in_fewbricks_info_pane(true)
            ->set_style('seamless')
            ->register();

    }

}

```

Then you could create and register the field group by calling `(new Content('Content', '1812010004a'')
->set_up()`.

## Constructor arguments

### 1. Label
The label of the field group which will be used when showing the field group in the backend.

### 2. Key
The second argument when creating a field group is a key that must be unique across the site. Check [the FAQ](/faq/)
for more on keys.

## ACF settings
Check [Fields](/fields/#acf-settings) for info on ACF settings.

## Fewbricks functions
Besides setting and getting all the ACF settings, the following functions are available for you to interact with field
groups. For info on which arguments to pass to each function, please refer to each functions docblock or body in the
code.

`add_brick()` - read more about Bricks under [Bricks](/bricks/).

`add_field()` - add fields to the field group. More on that under [Fields](/fields/).

`add_brick_before_by_name()` and `add_brick_after_field_by_name()` - add a Brick before/after an existing field by sending
the name of the field to add before/after.

`add_brick_to_beginning()`

`add_field_to_beginning()` and `add_fields_to_beginning()`

`add_field_after_field_by_name()`, `addFieldsAfterFieldByName()`, `add_field_before_field_by_name()` and
`add_fields_before_field_by_name()` - same as above but add field/fields instead of Bricks.

`remove_brick_by_key()` and `remove_brick_by_name()` - remove all fields that were added to a field group from a brick.

`remove_fields_by_key()`, `remove_field_by_key()`, `remove_field_by_name()` and `remove_fields_by_name()` - remove fields

`replace_field_by_key()` and `replace_field_by_name()` - replace existing field.

`add_arguments()` and `add_argument()` - add arbitrary arguments that you can use if you for example are using classes
to extend Fewbricks FieldGroup class.

`get_argument()` - retrieve an argument previously added to the field group.

`get_fields()` - get all the fields that has been added to the field group.

`get_field_by_name()` - get a field by the name of the field.

`set_field_labels_prefix()` - send a string to prefix the labels of all the fields in the group with.

`set_field_names_prefix()` - send a string to prefix the names of all the fields in the group with.

`clear_location_rule_groups()` - remove all location rules that have been set on the field group.

`set_show_in_fewbricks_info_pane()` - have info about the field group show up in [Fewbricks Info Pane](/info-pane/).

`set_title()` - change the title of the field group.
