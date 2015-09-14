<style>
    code {
        display: block;
        word-break: break-all;
        padding: 8px;
    }

    p {
        margin-top: 10px;
    }

    .demo-output-wrapper {
        border: solid red;
        border-width: 4px 0;
        padding: 18px 0;
    }

    .demo-h2 {
        background: black;
        color: white;
        text-align: center;
        padding: 8px;
    }

</style>

<h1>Fewbricks demo</h1>

<p>This page is using the template named "fewbricks demo" which gets its bricks in the file
    fewbricks/project/field-groups/field-groups-demo.php. If you are logged in, you can <a
        href="<?php echo get_edit_post_link(); ?>" target="_blank">edit the content here</a>.</p>





<h2 class="demo-h2">Field Group "Main content 1"</h2>

<p><b>This code:</b></p>

<?php
$snippet = "<?php

    // To get data from fields added directly to the field group we can use standard ACF get_field()
    echo '<p>' . get_field('some_text') . '</p>';
    echo '<p>' . get_field('some_more_text') . '</p>';

    // Create an instance of a brick and pass the name given when adding it to the field group
    // lets also pass two layouts for demo purposes.
    echo (new \fewbricks\bricks\demo_video('video_1'))->get_html([], ['demo-layout-1', 'demo-layout-2']);

?>";
?>

<code>
    <?php echo highlight_string($snippet, true); ?>
</code>

<p><b>..outputs all of the below between the red lines</b></p>

<div class="demo-output-wrapper">

    <?php
    echo '<p>' . get_field('some_text') . '</p>';
    echo '<p>' . get_field('some_more_text') . '</p>';
    echo (new \fewbricks\bricks\demo_video('video_1'))->get_html([], ['demo-layout-1', 'demo-layout-2']);
    ?>

</div>




<h2 class="demo-h2">Field Group "Main content 2"</h2>

<p><b>This code:</b></p>

<?php
$snippet = "<?php
    echo (new \\fewbricks\\bricks\\demo_buttons_list('button_list'))->get_html();
    echo (new \\fewbricks\\bricks\\demo_standard_list('a_list'))->get_html();
?>";
?>

<code>
    <?php echo highlight_string($snippet, true); ?>
</code>

<p><b>..outputs all of the below between the red lines</b></p>

<div class="demo-output-wrapper">

    <?php
    echo (new \fewbricks\bricks\demo_buttons_list('button_list'))->get_html();
    echo (new \fewbricks\bricks\demo_standard_list('a_list'))->get_html();
    ?>

</div>




<h2 class="demo-h2">Field Group "Main content 3"</h2>

<p><b>This code:</b></p>

<?php
$snippet = "<?php
    // loop through the rows of data
    while ( have_rows('fc1') ) {

        the_row();

        echo \\fewbricks\\acf\\fields\\flexible_content::get_sub_field_brick_instance()
          ->get_html();

    }

?>";
?>

<code>
    <?php echo highlight_string($snippet, true); ?>
</code>

<p><b>..outputs all of the below between the red lines</b></p>

<div class="demo-output-wrapper">

    <?php
    // loop through the rows of data
    while ( have_rows('fc1') ) {

        the_row();

        echo \fewbricks\acf\fields\flexible_content::get_sub_field_brick_instance()
          ->get_html();

    }

    ?>

</div>






<h2 class="demo-h2">Field Group "Main content 4"</h2>

<p><b>This code:</b></p>

<?php
$snippet = "<?php
    echo (new \\fewbricks\\bricks\\demo_flexible_brick('fb1'))->get_html();
?>";
?>

<code>
    <?php echo highlight_string($snippet, true); ?>
</code>

<p><b>..outputs all of the below between the red lines</b></p>

<div class="demo-output-wrapper">

    <?php
    echo (new \fewbricks\bricks\demo_flexible_brick('fb1'))->get_html();
    ?>

</div>






<h2 class="demo-h2">Field Group "Main content 5"</h2>

<p><b>This code:</b></p>

<?php
$snippet = "<?php
    echo (new \\fewbricks\\bricks\\demo_flexible_brick('fb1'))->get_html();
?>";
?>

<code>
    <?php echo highlight_string($snippet, true); ?>
</code>

<p><b>..outputs all of the below between the red lines</b></p>

<div class="demo-output-wrapper">

    <?php
    echo (new \fewbricks\bricks\demo_flexible_columns('fcol1'))->set_setting('nr_of_columns', 2)->get_html();
    ?>

</div>