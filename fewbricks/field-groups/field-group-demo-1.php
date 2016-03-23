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

// --- FIELD GROUP 1 ---

// Create field group
$fg = (new fewacf\field_group('Main content 1', '150901113b', $location, 1));

// Add some fields
$fg->add_field(new acf_fields\text('Some texts', 'some_text', '1509011120p'));
$fg->add_field(new acf_fields\text('Some more text', 'some_more_text', '1509011120x'));

// Add a brick
$fg->add_brick((new bricks\demo_video('video_1', '1509011120x'))
    ->set_field_label_prefix('A great video')
);

// Register the field group
$fg->register();


// --- FIELD GROUP 2 ---
$fg = (new fewacf\field_group('Main content 2', '1509111339o', $location, 2));
$fg->add_brick((new bricks\demo_buttons_list('button_list', '1509052316o'))->set_field_label_prefix('Button list'));
$fg->add_brick((new bricks\demo_standard_list('a_list', '1509042107u'))->set_field_label_prefix('A list'));
$fg->register();


// --- FIELD GROUP 3 ---
$fg = (new fewacf\field_group('Main content 3', '1509111453p', $location, 3));

$fc = (new acf_fields\flexible_content('Flexible content 1', 'fc1', '150901113c'));

// Leave name empty of you want it o be set to the same as that of the brick that you add
$l = new fewacf\layout('', 'layout_1', '1509042218o');
$l->add_brick((new bricks\demo_video('video', '1509042222u'))->set_arg('no_bg_color', true));
$fc->add_layout($l);

$l = new fewacf\layout('', 'layout_2', '1509060002y');
$l->add_brick(new bricks\demo_buttons_list('blist2', '1509060001t'));
$fc->add_layout($l);

$fg->add_flexible_content($fc);

$fg->register();


// --- FIELD GROUP 4 ---
$fg = (new fewacf\field_group('Main content 4', '1509111553y', $location, 4));

$fg->add_brick(new bricks\demo_flexible_brick('fb1', '1509111553r'));

$fg->register();


// --- FIELD GROUP 5 ---
$fg = (new fewacf\field_group('Main content 5', '1509141034o', $location, 5));

$fg->add_brick((new bricks\demo_flexible_columns('fcol1', '1509141034p'))->set_arg('nr_of_columns', 2));

$fg->register();