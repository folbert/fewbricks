<?php
use \Fewbricks\DevTools;
?>

<div id="fewbricks-dev-tools">
    <div>

        <h1>Fewbricks\DevTools</h1>

        <?php
        if(!empty(DevTools::getAcfSettingsArrays())) {
            ?>

            <h2>Data sent to ACF</h2>

            <?php
            if (!empty(DevTools::getFilterString())) {
                ?>

                <p>Using the filter "fewbricks/fewbricks/dev_tools/acf_arrays/keys", you asked DevHelper to display data
                    for:<br>
                    <?php echo DevTools::getFilterString(); ?></p>

                <?php
            }
            ?>

            <p>If the data below is displayed using dump(), you can expand all items in an array by holding `CMD`
                and click on a right-arrow.</p>

            <?php

            foreach (DevTools::getAcfSettingsArrays() AS $acfSettingsArray) {

                ?>
                <h3 class="fewbricks-dev-tools__section-sub-title"><?php echo DevTools::getTitleFromAcfArray($acfSettingsArray);
                ?></h3>

                <?php

                ob_start();

                if (function_exists('dump')) {
                    dump($acfSettingsArray);
                } else {
                    echo '<pre class="fdt-pre">';
                    print_r($acfSettingsArray);
                    echo '</pre>';
                }

                echo ob_get_clean();

            }

            ?>

            <?php
        } // End checking if acf settings arrays are empty
        ?>

        <h2>Dev mode</h2>
        <a href="<?php echo \Fewbricks\Helpers\Helper::getDocumentationUrl('filters/dev_mode/'); ?>" target="_blank">DevMode</a>
        is <?php echo (\Fewbricks\Helpers\Filters::dev_mode_is_enabled() ? 'enabled' : 'disabled') ?>.

        <h2>Execution time</h2>
        <p>Execution time for everything using the action "fewbricks/init":<br>
            <?php echo DevTools::getExecutionTime();  ?> seconds.</p>

        <h2>Versions</h2>
        <b>Fewbricks:</b> <span><?php echo \Fewbricks\Fewbricks::getVersion(); ?></span><br>
        <b>PHP:</b> <span><?php echo \Fewbricks\Helpers\Helper::getPhpVersion(); ?></span>

        <h2>Misc</h2>
        <ul>
            <li><a href="<?php echo admin_url('edit.php?post_type=acf-field-group&page=fewbricksdev'); ?>"
                   target="_blank">Fewbricks
                    admin page</a></li>
            <li><a href="<?php \Fewbricks\Helpers\Helper::getDocumentationUrl(); ?>" target="_blank">Fewbricks2 Documentation</a></li>
            <li><a href="https://github.com/folbert/fewbricks" target="_blank">Fewbricks on GitHub</a></li>
        </ul>

        <div class="fewbricks-dev-tools__togglers-wrapper">
            <button class="fewbricks-dev-tools__toggler" data-height="minimized">Minimized</button>
            <button class="fewbricks-dev-tools__toggler" data-height="33">33%</button>
            <button class="fewbricks-dev-tools__toggler" data-height="50">50%</button>
            <button class="fewbricks-dev-tools__toggler" data-height="100">100%</button>
        </div>

    </div>
</div>
