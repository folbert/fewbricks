<?php

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;

$location = [
    [
        [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
        ],
    ]
];

$fg = (new fewacf\field_group('Main content 1', '150901113b', $location, 1));

$fg->add_brick((new bricks\buttons_list('button_list', '1509052316o'))->set_field_label_prefix('Button list'));
$fg->add_brick((new bricks\standard_list('a_list', '1509042107u'))->set_field_label_prefix('A list'));
$fg->add_brick((new bricks\standard_list('another_list', '1509042107o'))->set_field_label_prefix('Another list'));

$fc = (new acf_fields\flexible_content('Flexible content 1', 'fc1', '150901113c'));
$l = new fewacf\layout('Layout 1', 'layout_1', '1509042218o');
$l->add_brick(new bricks\youtube('youtube_2', '1509042222u'));
$fc->add_layout($l);
$l = new fewacf\layout('Layout 1', 'layout_2', '1509060002y');
$l->add_brick(new bricks\buttons_list('blist2', '1509060001t'));
$fc->add_layout($l);
$fg->add_flexible_content($fc);

$fg->add_field(new acf_fields\text('Some text', 'some_text', '1509011120p'));
$fg->add_field(new acf_fields\text('Some more text', 'some_more_text', '1509011120x'));
$fg->add_brick((new bricks\youtube('youtube_1', '1509011120x'))->set_field_label_prefix('Det draaaar!'));
$fg->add_brick((new bricks\button('button', '1509032106a')));

$fg->register();

/*
$fg = new fewacf\field_group('1509011031a', 'Made of standard bricks', $location, 2);
$fg->add_brick(new bricks\youtube('youtube_test_2000', ['label_prefix' => 'YouTube 1'], '1509011316p'));
$fg->add_brick(new bricks\youtube('youtube_test_3000', ['label_prefix' => 'YouTube 2'], '1509011317u'));
$fg->register();


$fg = new fewacf\field_group('1509011131o', 'Flexible columns brick 1', $location, 3);
$fg->add_brick(new bricks\flexible_columns('flexcol1', ['nr_of_columns' => 3], '1509011317o'));
$fg->register();

$fg = new fewacf\field_group('1509011155i', 'Flexible columns brick 2', $location, 4);
$fg->add_brick(new bricks\flexible_columns('flexcol3', ['nr_of_columns' => 3], '1509011211d'));
$fg->register();

$fg = new fewacf\field_group('1504171906y', 'Main content', $location, 1); //
$fc = new fewacf\flexible_content('1501291723y', 'main_content_bricks', 'Bricks');
$fc->add_layout((new fewacf\layout('1504171054p'))->add_brick(new bricks\youtube('youtube', [], '1509011432p')));
//$fc->add_layout((new fewacf\layout('1504172116i'))->add_brick(new bricks\flexible_brick('flexmod', [], '1509011439y')));
//$fc->add_layout((new fewacf\layout('1508191105x'))->add_brick(new bricks\flexible_content('fco', ['nr_of_columns' => 2], '1509011440s')));
//$fc->add_layout((new fewacf\layout('1508240841o'))->add_brick(new bricks\flexible_columns('fc', ['nr_of_columns' => 2], '1509011440b')));
$fg->add_field($fc);
$fg->register();
*/