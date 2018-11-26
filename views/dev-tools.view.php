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

            foreach (DevTools::getAcfSettingsArrays() AS $acf_settings_array) {

                ?>
                <h3 class="fewbricks-dev-tools__section-sub-title"><?php echo DevTools::getTitleFromAcfArray($acf_settings_array);
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

        <h2>Execution time</h2>
        <p>Execution time for everything using the action "fewbricks/init":<br>
            <?php echo DevTools::getExecutionTime();  ?> seconds.</p>

        <h2>Fewbricks version</h2>
        <span><?php echo \Fewbricks\Fewbricks::getVersion(); ?></span>

        <h2>Misc</h2>
        <ul>
            <li><a href="https://fewbricks2.folbert.com" target="_blank">Fewbricks2 Documentation</a></li>
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
