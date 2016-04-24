<?php

if(\fewbricks\helpers\is_fewbricks_in_developer_mode()) {

    $fewbricks_success_message = false;
    $fewbricks_error_message = false;

    if (isset($_POST['fewbricks_buildjson'])) {
        $_POST['fewbricks_deletejson'] = true;
    }

    if (isset($_POST['fewbricks_deletejson'])) {

        if (file_exists(get_stylesheet_directory() . '/acf-json/')) {

            $files = glob(get_stylesheet_directory() . '/acf-json/*');

            foreach ($files AS $file) {
                unlink($file);
            }

            $fewbricks_success_message = 'ACF JSON files have been deleted.';

        } else {

            $fewbricks_error_message = 'There must be a folder named "acf-json" in the theme directory for ACF Local JSON to work.';

        }

    }

    if (isset($_POST['fewbricks_buildjson'])) {

        if (file_exists(get_stylesheet_directory() . '/acf-json/')) {

            global $fewbricks_save_json;
            $fewbricks_save_json = true;
            /** @noinspection PhpIncludeInspection */
            require(get_stylesheet_directory() . '/fewbricks/field-groups/init.php');

            $fewbricks_success_message = 'ACF JSON files have been saved.';

        } else {

            $fewbricks_error_message = 'There must be a folder named "acf-json" in the theme directory for ACF Local JSON to work.';

        }

    }

    ?>

    <h2>Fewbricks</h2>

    <?php
    if ($fewbricks_success_message !== false) {
        ?>
        <div id="message" class="updated notice is-dismissible below-h2">
            <p><?php echo $fewbricks_success_message; ?></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>
        <?php
    }

    ?>

    <div class="wrap acf-settings-wrap">

        <div class="acf-box">

            <div class="title"><h3>Build local JSON</h3></div>

            <div class="inner">

                <form action="" method="post">

                    <p>Click the button below to build local JSON. Local JSON is an ACF feature which "is similar to caching and both dramatically speeds up ACF and allows for version control over your field settings". Read more about it at <a href="http://www.advancedcustomfields.com/resources/local-json/" target="_blank">the ACF site</a></p>

                    <p>Note that building JSON will first delete _all_ files in the acf-json directory.</p>

                    <input type="submit" name="fewbricks_buildjson" value="Build ACF Local JSON" class="button"/>
                </form>

                <h4>Current files in acf-json</h4>

                <?php

                if (file_exists(get_stylesheet_directory() . '/acf-json/')) {

                    $files = glob(get_stylesheet_directory() . '/acf-json/*');

                    if (!empty($files)) {

                        echo '<ul>';

                        foreach ($files AS $file) {

                            echo '<li>' . basename($file) . '</li>';

                        }

                        echo '</ul>';

                    } else {

                        echo 'There are no files in the directory "acf-json"';

                    }

                } else {

                    echo 'The directory "acf-json" does not exist.';

                }

                ?>

            </div>

        </div>

        <div class="acf-box">

            <div class="title"><h3>Delete local JSON</h3></div>

            <div class="inner">

                <form action="" method="post">

                    <p>Click the button below to empty the folder containing the ACF Local JSON-files.</p>
                    <input type="submit" name="fewbricks_deletejson" value="Delete ACF Local JSON" class="button"/>
                </form>

            </div>

        </div>

        <div class="acf-box">

            <div class="title"><h3>Developer mode</h3></div>

            <div class="inner">

              <?php
                if(\fewbricks\helpers\is_fewbricks_in_developer_mode()) {
              ?>
                <p>Fewbricks developer mode is active.</p>
              <?php
              } else {
              ?>
                <p>Fewbricks developer mode is _not_ active.</p>
              <?php
              }
              ?>

                <p>By setting Fewbricks in developer mode, some extra debugging related to Febricks and ACF will become available. Also, every time a field group is registered, a check for duplicate keys will be carried out. Please make sure that you don't have developer mode enabled on production servers since this will have impact on performance. Read more about Fewbricks developer mode and how to enable it in the <a href="https://github.com/folbert/fewbricks/blob/master/README.md">Fewbricks README file</a>.</p>

                <p>If developer mode is enabled, you can also var dump all registered field groups and its fields each time a field group is registered. This is done by adding a get variable named "dumpfewbricksfields" to any page. For example <a href="<?php echo get_option('home'); ?>/?dumpfewbricksfields" target="_blank"><?php echo get_option('home'); ?>/?dumpfewbricksfields</a></p>

            </div>

        </div>

    </div>


    <?php

} else {

    wp_die('This page is only available if developer mode for Fewbricks is enabled. For more info on this, see README.md');

}

//require(__DIR__ . '/../field-groups/init.php');