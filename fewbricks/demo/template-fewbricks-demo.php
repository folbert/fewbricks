<?php
/**
 * Template Name: Fewbricks Demo
 */

/**
 * This file holds code for showing how to use Fewbricks in your templates.
 * In order to use out of the box, don't add any wp_head or similar code to it since we want a clean
 * Bootstrap setup.
 * We are also including CSS for Query Monitor in case you are running that.
 */
?>

<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Fewbricks Demo</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  /**
   * Style QueryMonitor if that is being used.
   */
  if(class_exists('QueryMonitor')) {
  ?>
    <link rel="stylesheet" href="<?php echo plugins_url('query-monitor'); ?>/assets/query-monitor.css" type="text/css"
          media="all"/>
  <?php
  }
  ?>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <style>
    code {
      display: block;
      word-break: break-all;
      padding: 8px;
    }

    p {
      margin-top: 10px;
    }
  </style>

</head>
<body>

<?php

echo (new \fewbricks\bricks\demo_jumbotron('jumbotron'))->get_html();

?>

<div class="container">
  <div class="row">
    <div class="col-xs-12">

      <?php

      echo (new \fewbricks\bricks\demo_flexible_columns('fcol1'))->get_html();

      ?>

      <hr>

      <?php

      echo (new \fewbricks\bricks\demo_flexible_columns('fcol2'))->get_html();

      ?>

      <hr>

      <?php
      // loop through the rows of data
      while ( have_rows('fc1') ) {

        the_row();

        /** @noinspection PhpUndefinedMethodInspection */
        echo \fewbricks\acf\fields\flexible_content::get_sub_field_brick_instance()->get_html(false, 'demo-layout-2');

      }

      ?>

      <hr>

      <?php

      echo (new \fewbricks\bricks\demo_buttons_list('buttons_list'))->get_html(false, ['demo-layout-1']);

      ?>

      <hr>

      <?php

      echo (new \fewbricks\bricks\demo_standard_list('a_list'))->get_html(false, ['demo-layout-2']);

      ?>

      <hr>

      <footer>
        <p><?php echo get_field('footer_text'); ?></p>
      </footer>

    </div>
  </div>

</div> <!-- /container -->

<?php

wp_footer();

?>

</body>
</html>