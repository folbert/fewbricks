<?php

use fewbricks\bricks AS bricks;
use fewbricks\acf AS fewacf;


$location = [
  [
    [
      'param' => 'options_page',
      'operator' => '==',
      'value' => 'acf-options-options',
    ],
  ]
];


$fg = new fewacf\field_group('options_cookie_alert', 'Cookie alert', $location, 2);
$fg->add_brick((new bricks\cookie_alert('cookie_alert')), '1504172309d');
$fg->register();