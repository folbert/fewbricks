<?php

    $bg_color = $this->get_field('demo_background_color');

    if(!empty($bg_color)) {
        $bg_css = ' background: ' . $bg_color;
    }

?>

<div style="border:solid 2px red;<?php echo $bg_css; ?>">
    <?php echo $html; ?>
</div>