<?php

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;

$location = [
    [
        [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'project',
        ],
    ]
];

/**
 * Info
 */
// Create field group
$fg = (new fewacf\field_group('Info', '1603222002d', $location, 5, [
    'style' => 'seamless'
]));

// Add some fields
$fg->add_field(new acf_fields\wysiwyg('Info', 'info', '1603222004d', [

]));

// Register the field group
$fg->register();

/**
 * Project categories
 */
// Create field group
$fg = (new fewacf\field_group('Project categories', '1603222002e', $location, 7, [
    'style' => 'seamless'
]));

// Add some fields
$fg->add_field(new acf_fields\taxonomy('Project categories', 'project_categories', '1603222004e', [
    'load_terms' => 1,
    'save_terms' => 1,
    'taxonomy' => 'project_category',
    'required' => 1,
    'multiple' => 1,
    'add_term' => 1,
    'field_type' => 'checkbox'
]));

$fg->register();

/**
 * Employer
 */
// Create field group
$fg = (new fewacf\field_group('Employer', '1603222002a', $location, 10, [
    'style' => 'seamless'
]));

// Add some fields
$fg->add_field(new acf_fields\taxonomy('Employer', 'employer', '1603222004a', [
    'load_terms' => 1,
    'save_terms' => 1,
    'taxonomy' => 'employer',
    'required' => 1
]));

$fg->register();

/**
 * Released
 */
// Create field group
$fg = (new fewacf\field_group('First released', '1603222002b', $location, 20, [
    'style' => 'seamless'
]));

// Add some fields
$fg->add_field(new acf_fields\date_picker('First released', 'date', '1603222004b', [
    'required' => 1
]));

// Register the field group
$fg->register();

/**
 * URL
 */
// Create field group
$fg = (new fewacf\field_group('URL', '1603222002c', $location, 30, [
    'style' => 'seamless'
]));

// Add some fields
$fg->add_field(new acf_fields\url('URL', 'url', '1603222004c', [

]));

// Register the field group
$fg->register();