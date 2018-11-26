<?php
use \Fewbricks\DevTools;
?>

<div id="fewbricks-dev-tools">
    <div>

        <h1>Fewbricks\DevTools</h1>

        <h2>Data sent to ACF</h2>

        <p>Using the filter "fewbricks/fewbricks/dev_tools/keys", you asked DevHelper to display data for:<br>
            <?php echo DevTools::getFilterString(); ?></p>

<?php

    foreach (DevTools::getAcfSettingsArrays() AS $acf_settings_array) {

?>
        <h3 class="fewbricks-dev-tools__section-sub-title"><?php echo $acf_settings_array['title']; ?></h3>

<?php

        ob_start();

        if (function_exists('dump')) {
            dump($acf_settings_array);
        } else {
            echo '<pre>';
            var_dump($acf_settings_array);
            echo '</pre>';
        }

        echo ob_get_clean();

}

?>

        <h2>Execution time</h2>
        <p>Execution time for everything using the action "fewbricks/init":<br>
            <?php echo DevTools::getExecutionTime();  ?> seconds.


        <div class="fewbricks-dev-tools__togglers-wrapper">
            <button class="fewbricks-dev-tools__toggler" data-height="100">100%</button>
            <button class="fewbricks-dev-tools__toggler" data-height="50">50%</button>
            <button class="fewbricks-dev-tools__toggler" data-height="33">33%</button>
            <button class="fewbricks-dev-tools__toggler" data-height="minimized">Minimized</button>
        </div>

    </div>
</div>
