<?php

$button_brick = $this->get_child_brick('demo_button', 'button');
$button_brick->set_css_class('btn btn-primary btn-lg');

echo '
<div class="jumbotron">
  <div class="container">
    <h1>' . $this->get_field('headline') . '</h1>
    <div>
        ' . $this->get_field('text') . '
    </div>
    ' . $button_brick->get_html() . '
  </div>
</div>
';
