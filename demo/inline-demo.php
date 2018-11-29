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
use Fewbricks\ACF\Fields\Image;
use Fewbricks\ACF\Fields\Link;
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
    ->prefixLabel('Please answer this question: '); // Fewbricks feature

$other_favourite_character = (new Text('My favourite character is none of the above but:', 'other_favourite_character',
    '1811262140a'))
    ->addConditionalLogicRuleGroup
    (
        (new ConditionalLogicRuleGroup())
            ->addConditionalLogicRule(
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

(new FieldGroup('Dark Tower Contest', '1811252128a'))
    ->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup())
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('post_type', '==', 'post') // When editing a post)
            )
    )// ...or ...
    ->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup())
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('post_type', '==', 'page') // When editing a page
            )
            ->addFieldGroupLocationRule(
                new FieldGroupLocationRule('user_role', '==', 'editor') // And the user is an editor
            )
    )
    ->setShowInFewbricksDevTools(true)
    ->setHideOnScreen('all')
    ->setShowOnScreen('permalink')
    ->addField($favourite_character)
    ->addField($other_favourite_character)
    ->addFields([
        $motivation,
        (new Email('Enter your e-mail for a chance to win!', 'e_mail', '1811281100a'))
            ->setRequired(true)
    ])
    ->addBrick(
        (new ImageAndText('image_and_name', '1811290826a'))// What's this now? Read on to find out!
        ->addArgument('text_label', 'Name')
            ->addArgument('text_name', 'name')
    )
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
