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
use Fewbricks\ACF\Fields\Extensions\AcfCodeField;
use Fewbricks\ACF\Fields\Extensions\DynamicYearSelect;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Wysiwyg;
use FewbricksDemo\Bricks\ImageAndText;

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
            ->setRequired(true),
        (new DynamicYearSelect('Select a year', 'year', '1812012249a'))
            ->setNewestYear([
                'method' => 'relative',
                'relative_year' => '20',
            ])
            ->setOldestYear([
                'method' => 'relative',
                'relative_year' => '2',
            ]),
        (new AcfCodeField('Code', 'code', '1812012332a'))->setMode('application/x-httpd-php')->setPlaceholder('Placehålder')->setDefaultValue('Default value'),
    ])
    // What's a brick you wonder? Read under Bricks for more info
    ->addBrick(
        (new ImageAndText('image_and_name', '1811290826a'))
            ->addArgument('text_label', 'Name')
            ->addArgument('text_name', 'name')
    )
    // Finish up by registering the field group to ACF.
    ->register();

/**
 * Add a field group to the options page
 */

(new FieldGroup('Social media', '1811292250a'))
    ->addFields([
        (new Text('Facebook URL', 'global_data_facebook_url', '1811292252a')),
        (new Text('Instagram URL', 'global_data_instagram_url', '1811292252b')),
        (new Text('Twitter URL', 'global_data_twitter_url', '1811292252c')),
    ])
    ->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup())
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('options_page', '==', 'fewbricks-demo-options--global-texts')
            )
    )
    ->register();
