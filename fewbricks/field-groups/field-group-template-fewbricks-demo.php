<?php

/**
 * Example file on how to build field groups.
 * "Namespacing" by prefixing variable names with "fewbricks" is optional
 * but is recommended to avoid the, clashing with other data in WordPress.
 */

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;
use fewbricks\acf\fields AS acf_fields;

/**
 * Define where the field group should be used
 */
$fewbricks_fg_location = [
    [
        [
            'param' => 'page_template',
            'operator' => '==',
            'value' => 'template-fewbricks-demo.php',
        ],
    ]
];

/**
 * Lets  create a bunch of field groups.
 * The reason for increasing the order-argument by then is that it makes it easier to add new field groups
 * in between existing ones later on.
 * Make sure that you check out the bricks that we create instances of here to get a sense of what is going on.
 */

/**
 * Jumbotron
 * Showing how to use a simple brick.
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - Jumbotron', '1603242318a', $fewbricks_fg_location, 10));

$fewbricks_fg->add_brick(new bricks\demo_jumbotron('jumbotron', '1603242319a'));

$fewbricks_fg->register();

/**
 * 3 Columns
 * This, along with "2 columns" below, shows how you can use the same brick twice and by passing data to it,
 * make it behave differently.
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - 3 Columns', '1509141034o', $fewbricks_fg_location, 20));

$fewbricks_fg->add_brick((new bricks\demo_flexible_columns('fcol1', '1509141034p'))->set_arg('nr_of_columns', 3));

$fewbricks_fg->register();

/**
 * 2 Columns.
 * Note that we are using the same brick as for the three columns above but passing 2 instead of 3 as nr of columns.
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - 2 Columns', '1603242355a', $fewbricks_fg_location, 30));

$fewbricks_fg->add_brick((new bricks\demo_flexible_columns('fcol2', '1603242355b'))->set_arg('nr_of_columns', 2));

$fewbricks_fg->register();

/**
 * Flexible content on the fly.
 * Showing how it is possible to build complex flexible contents on the fly
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - Flexible content on the fly', '1509111453p', $fewbricks_fg_location, 35));

$fewbricks_fc = (new acf_fields\flexible_content('Flexible content 1', 'fc1', '150901113c'));

// Leave name empty of you want it o be set to the same as that of the brick that you add
$fewbricks_l = new fewacf\layout('', 'layout_1', '1509042218o');
$fewbricks_l->add_brick((new bricks\demo_video('video', '1509042222u'))->set_arg('no_bg_color', true));
$fewbricks_fc->add_layout($fewbricks_l);

$fewbricks_l = new fewacf\layout('', 'layout_2', '1509060002y');
$fewbricks_l->add_brick(new bricks\demo_buttons_list('blist2', '1509060001t'));
$fewbricks_fc->add_layout($fewbricks_l);

$fewbricks_fg->add_flexible_content($fewbricks_fc);

$fewbricks_fg->register();

/**
 * Buttons list
 * Check demo_buttons_list to see how to set up repeaters.
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - Buttons list', '1509111339o', $fewbricks_fg_location, 40));

$fewbricks_fg->add_brick((new bricks\demo_buttons_list('buttons_list', '1509052316o'))->set_field_label_prefix('Button list'));

$fewbricks_fg->register();

/**
 * Standard list
 * Also showing off repeaters.
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - Standard list', '1509111339p', $fewbricks_fg_location, 50));

$fewbricks_fg->add_brick((new bricks\demo_standard_list('a_list', '1509042107x'))->set_field_label_prefix('A list'));

$fewbricks_fg->register();

/**
 * Footer.
 * Shows how to use fields directly in a field group without setting up a brick.
 * Normally you would put global data like this in an options page
 * (http://www.advancedcustomfields.com/resources/acf_add_options_page/). To achieve this,
 * create the options page as decribed by ACF and then set the location to match that options page.
 */
$fewbricks_fg = (new fewacf\field_group('Fewbricks Demo - Footer', '1603242347a', $fewbricks_fg_location, 200));

$fewbricks_fg->add_field(new acf_fields\text('Footer text', 'footer_text', '1603242348a'));

$fewbricks_fg->add_field(new acf_fields\date_picker('Date picker', 'date_picker', '1712122240a'));

$fewbricks_fg->add_field(new acf_fields\date_time_picker('Date time picker', 'date_time_picker', '1712122240b'));

$fewbricks_fg->register();
