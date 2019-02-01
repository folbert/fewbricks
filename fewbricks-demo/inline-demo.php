<?php

/**
 * This file demos how you can register field groups and fields without wrapping your code in classes.
 */

namespace FewbricksDemo;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Email;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Wysiwyg;
use FewbricksDemo\Bricks\ImageAndText;

$favourite_character = (new Select('Who is your favourite character?', 'favourite_character', '1811262140b'))
    ->set_choices([
        'roland' => 'Roland Deschain',
        'jake' => 'Jake Chambers',
        'susan' => 'Susan Delgado',
        'eddie' => 'Eddie Dean',
        'oy' => 'Oy',
        'other' => 'Other',
    ])
    ->set_allow_null(false)
    ->set_required(true)
    // Fewbricks feature allowing you to prefix the label.
    ->prefix_label('Please answer this question: ');

$other_favourite_character = (new Text('My favourite character is none of the above but:', 'other_favourite_character',
    '1811262140a'))
    ->add_conditional_logic_rule_group
    (
        (new ConditionalLogicRuleGroup())
            ->add_conditional_logic_rule(
                // Onlu dusplay this field if the field with key "1811262140b" is set to "other".
                new ConditionalLogicRule('1811262140b', '==', 'other')
            )
    )
    ->set_required(true)
    ->set_placeholder('Maybe Randall Flagg?');

$motivation = (new Wysiwyg('Please motivate', 'motivation', '1811292147a'))
    ->set_instructions('Feel free to add a motivation as to why your favourite characters is the one you stated above.')
    ->set_delay(true)
    ->set_media_upload(false)
    ->set_tabs('visual')
    ->set_wrapper(['id' => 'favourite_character_motivation']);

(new FieldGroup('Main content', '1811252128a'))
    // Tell the field group when it should show up
    ->add_location_rule_group(
        (new FieldGroupLocationRuleGroup())
            ->add_field_group_location_rule(
            // When editing a post
                new FieldGroupLocationRule('post_type', '==', 'fewbricks_demo_pg')
            )
    )
    // Hide everything on screen that ACF can hide...
    ->set_hide_on_screen('all')
    // ...but show the permalink
    ->set_show_on_screen('permalink')
    // Add a single field or...
    ->add_field($favourite_character)
    // ...add multiple fields.
    ->add_fields([
        $other_favourite_character,
        $motivation,
        // Create an inline field
        (new Email('Enter your e-mail for a chance to win!', 'e_mail', '1811281100a'))
            ->set_required(true),
    ])
    // What's a brick you wonder? Read under Bricks for more info
    ->add_brick(
        (new ImageAndText('1811290826a', 'image_and_name'))
            ->add_argument('text_label', 'Name')
            ->add_argument('text_name', 'name')
    )
    // Finish up by registering the field group to ACF.
    ->register();

/**
 * Add a field group to the options page
 */

(new FieldGroup('Social media', '1811292250a'))
    ->add_fields([
        (new Text('Facebook URL', 'global_data_facebook_url', '1811292252a')),
        (new Text('Instagram URL', 'global_data_instagram_url', '1811292252b')),
        (new Text('Twitter URL', 'global_data_twitter_url', '1811292252c')),
    ])
    ->add_location_rule_group(
        (new FieldGroupLocationRuleGroup())
            ->add_field_group_location_rule(
                new FieldGroupLocationRule('options_page', '==', 'fewbricks-demo-options--global-texts')
            )
    )
    ->register();
