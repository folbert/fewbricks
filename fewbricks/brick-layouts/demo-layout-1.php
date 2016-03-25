<?php
/**
 * Demo brick layout.
 * A layout have access to the current brick via $this and the bricks HTML via $html.
 */
?>

<?php

    $fewbricks_bg_color = $this->get_field('demo_background_color');

    if(!empty($fewbricks_bg_color)) {
        $fewbricks_bg_css = ' background: ' . $fewbricks_bg_color;
    }

?>

<div style="border:solid 2px red;<?php echo $fewbricks_bg_css; ?>">
    <?php echo $html; ?>
</div>