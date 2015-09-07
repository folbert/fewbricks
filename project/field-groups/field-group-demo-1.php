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
$l->add_brick(new bricks\video('video', '1509042222u'));
$fc->add_layout($l);
$l = new fewacf\layout('Layout 1', 'layout_2', '1509060002y');
$l->add_brick(new bricks\buttons_list('blist2', '1509060001t'));
$fc->add_layout($l);
$fg->add_flexible_content($fc);

$fg->add_field(new acf_fields\text('Some text', 'some_text', '1509011120p'));
$fg->add_field(new acf_fields\text('Some more text', 'some_more_text', '1509011120x'));
$fg->add_brick((new bricks\video('video_1', '1509011120x'))->set_field_label_prefix('A great video'));
$fg->add_brick((new bricks\button('button', '1509032106a')));
$fg->add_brick((new bricks\button('button2', '1509032106b')));

$fg->register();