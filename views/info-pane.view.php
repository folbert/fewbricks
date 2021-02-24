<?php
use \Fewbricks\InfoPane;
?>

<div id="fewbricks-info-pane">
    <div>

        <h1>Fewbricks\InfoPane</h1>

        <?php
        if(!empty(InfoPane::get_acf_settings_arrays())) {
            ?>

            <h2>Data sent to ACF</h2>

            <p>If the data below is displayed using dump(), you can expand all items in an array by holding `CMD`
                and click on a right-arrow.</p>

            <?php

            foreach (InfoPane::get_acf_settings_arrays() AS $acf_settings_array) {

                ?>
                <h3 class="fewbricks-info-pane__section-sub-title"><?php echo InfoPane::get_title_from_acf_array($acf_settings_array);
                ?></h3>

                <?php

                ob_start();

                if (function_exists('dump')) {
                    dump($acf_settings_array);
                } else {
                    echo '<pre class="fdt-pre">';
                    print_r($acf_settings_array);
                    echo '</pre>';
                }

                echo ob_get_clean();

            }

            ?>

            <?php
        } // End checking if acf settings arrays are empty
        ?>

        <h2>Dev mode</h2>
        <a href="<?php echo \Fewbricks\Helpers\Helper::get_documentation_url('filters/dev_mode/enable'); ?>" target="_blank">DevMode</a>
        is <?php echo (\Fewbricks\Helpers\Filters::dev_mode_is_enabled() ? 'enabled' : 'disabled') ?>.

        <h2>Execution time</h2>
        <p>Execution time for everything using the action "fewbricks/init":<br>
            <?php echo InfoPane::get_execution_time();  ?> seconds.</p>

        <h2>Versions</h2>
        <b>Fewbricks:</b> <span><?php echo \Fewbricks\Fewbricks::get_version(); ?></span><br>
        <b>PHP:</b> <span><?php echo \Fewbricks\Helpers\Helper::get_php_version(); ?></span>

        <h2>Misc</h2>
        <ul>
            <li><a href="<?php echo admin_url('edit.php?post_type=acf-field-group&page=fewbricksdev'); ?>"
                   target="_blank">Fewbricks
                    admin page</a></li>
            <li><a href="<?php \Fewbricks\Helpers\Helper::get_documentation_url(); ?>" target="_blank">Fewbricks2 Documentation</a></li>
            <li><a href="https://github.com/folbert/fewbricks" target="_blank">Fewbricks on GitHub</a></li>
        </ul>

        <div class="fewbricks-info-pane__togglers-wrapper">
            <button class="fewbricks-info-pane__toggler" data-fewbricks-info-pane-toggler data-fewbricks-info-pane-height="minimized">Minimized</button>
            <button class="fewbricks-info-pane__toggler" data-fewbricks-info-pane-toggler data-fewbricks-info-pane-height="33">33%</button>
            <button class="fewbricks-info-pane__toggler" data-fewbricks-info-pane-toggler data-fewbricks-info-pane-height="50">50%</button>
            <button class="fewbricks-info-pane__toggler" data-fewbricks-info-pane-toggler data-fewbricks-info-pane-height="100">100%</button>
        </div>

    </div>
</div>
