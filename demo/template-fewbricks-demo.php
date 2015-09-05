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
        border-top: solid 2px red;
        border-bottom: solid 2px red;
        padding: 18px 0;
    }

</style>

<h1>Fewbricks demo</h1>

<p>This page is using the template named "fewbricks demo" which gets its bricks in the file
    fewbricks/field-groups/field-groups-demo.php. If you are logged in, you can <a
        href="<?php echo get_edit_post_link(); ?>" target="_blank">edit the content here</a>.</p>

<h2>Field Group "Made of fields"</h2>

<p><b>This code:</b></p>

<?php
$snippet = "<?php
    echo '<p>' . get_field('some_text') . '</p>';
    echo '<p>' . get_field('some_more_text') . '</p>';
    echo (new \fewbricks\bricks\youtube('youtube_1'))->get_html();
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
echo (new \fewbricks\bricks\youtube('youtube_1'))->get_html();
?>

</div>