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

<div style="<?php echo $this->get_inline_css(); ?>border:solid 2px red;<?php echo $fewbricks_bg_css; ?>">
  <div style="<?php echo $this->get_inline_css('inner'); ?>">

    <?php
      $demo_data_item_value = $this->get_data_item('demo_data_item');
      if($demo_data_item_value !== false) {
        echo '<div>' . $demo_data_item_value . '</div>';
      }
    ?>

    <?php
    $demo_data_item_value = $this->get_data_item('demo_data_item', true, 'demo_group');
    if($demo_data_item_value !== false) {
      echo '<div>' . $demo_data_item_value . '</div>';
    }
    ?>

    <?php
    $demo_data_item_value = $this->get_data_item('demo_data_item_2', true, 'demo_group');
    if($demo_data_item_value !== false) {
      echo '<div>' . $demo_data_item_value . '</div>';
    }
    ?>

  </div>

  <?php echo $html; ?>
</div>