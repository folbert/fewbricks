<div class="wrap">
    <h1>Fewbricks</h1>

    <?php
    if (\Fewbricks\Helper::generatePhpCodeTriggered()) {

        $fieldGroupCodes
            = \Fewbricks\Helper::getFieldGroupsPhpCodes($_GET['fewbricks_selected_field_groups_for_export']);

        if (!empty($fieldGroupCodes)) {
            ?>

            <div class="acf-meta-box-wrap">
                <div class="postbox">

                    <h2 class="hndle"><?php _e('Export Field Groups', 'acf'); ?></h2>

                    <div class="inside">

                        <?php
                        if ($_GET['fewbricks_generate_php_split'] === 'one_per_field_group') {

                            foreach ($fieldGroupCodes AS $fieldGroupKey => $data) {
                                ?>
                                <p><label for="fewbricks-php-export-"<?php echo $fieldGroupKey; ?>><b>PHP Code for
                                            field group
                                            "<?php echo $data[0] . '"  with key <i>' . $fieldGroupKey
                                                        . '</i>'; ?></b></label></p>
                                <textarea readonly class="fewbricks__export-textarea"><?php echo $data[1]; ?></textarea>

                                <?php
                            }

                        } else {

                            $textarea_content = '';

                            foreach ($fieldGroupCodes AS $fieldGroupKey => $data) {

                                $textarea_content .= esc_textarea($data[1]);

                            }

                            echo '<textarea readonly class="fewbricks__export-textarea">' . $textarea_content
                                 . '</textarea>';

                        }
                        ?>

                    </div>

                </div>

            </div>

            <?php
        }

    }

    ?>


    <div class="acf-meta-box-wrap -grid">

        <div class="postbox">

            <h2 class="hndle"><?php _e('Export Fewbricks field groups and fields', 'fewbricks'); ?></h2>

            <div class="inside">

                <p><?php _e('Here you can export all the field groups and fields that are registered using 
                Fewbricks. Use the download button to export to a .json file which you can then import to another ACF installation. Use the generate button to export to PHP code which you can place in your theme.',
                        'fewbricks'); ?></p>

                <form action="<?php echo admin_url('edit.php'); ?>" method="get">

                    <div class="acf-fields">
                        <div class="acf-field acf-field-checkbox" data-name="keys" data-type="checkbox">

                            <div class="acf-label"><label><?php _e('Select field groups', 'fewbricks'); ?></label></div>

                            <div class="acf-input">

                                <?php

                                $fieldGroupData = \Fewbricks\Helper::getStoredSimpleFieldGroupData();

                                if (!empty($fieldGroupData)) {

                                    $checkboxesHtml = '<ul class="acf-checkbox-list acf-bl">';

                                    $checkboxesHtml .= '<li><label><input type="checkbox" class="acf-checkbox-toggle" data-fewbricks-toggle-all-siblings><i> '
                                                       . __('Toggle all', 'fewbricks') . '</i></li>';

                                    foreach ($fieldGroupData AS $fieldGroupKey => $fieldGroupTitle) {

                                        $checkboxesHtml .= '<li>';
                                        $checkboxesHtml .= '<label>';
                                        $checkboxesHtml .= '<input type="checkbox" ';
                                        $checkboxesHtml .= 'name="fewbricks_selected_field_groups_for_export[]" ';
                                        $checkboxesHtml .= 'value="' . $fieldGroupKey . '" ';

                                        if (isset($_GET['fewbricks_selected_field_groups_for_export'])
                                            && in_array($fieldGroupKey,
                                                $_GET['fewbricks_selected_field_groups_for_export'])
                                        ) {
                                            $checkboxesHtml .= 'checked="checked" ';
                                        }

                                        $checkboxesHtml .= '> ';
                                        $checkboxesHtml .= $fieldGroupTitle;
                                        $checkboxesHtml .= '</label>';
                                        $checkboxesHtml .= '</li>';

                                    }

                                    $checkboxesHtml .= '</ul>';

                                    echo $checkboxesHtml;

                                    ?>

                                    <hr>

                                    <div class="acf-label">
                                        <label for="fewbricks_generate_php_split"><?php _e('Generate (only applied when 
                                        generating PHP):', 'fewbricks'); ?></label>
                                    </div>
                                    <select name="fewbricks_generate_php_split" id="fewbricks_generate_php_split">
                                        <option value="one_per_field_group"><?php _e('One textarea per field 
                                        group', 'fewbricks'); ?></option>
                                        <option value="no_split"><?php _e('One textarea with all field groups in 
                                        it', 'fewbricks'); ?></option>
                                    </select>

                                    <p class="acf-submit">
                                        <button type="submit" name="action" class="button button-primary"
                                                value="fewbricks_export_json"><?php _e('Export JSON-file',
                                                'fewbricks'); ?></button>
                                        <button type="submit" name="action" class="button"
                                                value="fewbricks_generate_php"><?php _e('Generate PHP',
                                                'acf'); ?></button>
                                    </p>

                                    <?php wp_nonce_field('fewbricks_export_d89dtygodl', '_wpnonce', false); ?>
                                    <input type="hidden" name="post_type" value="acf-field-group"/>
                                    <input type="hidden" name="page" value="fewbricksdev"/>

                                    <?php

                                } else {
                                    ?>

                                    <p>
                                        <?php _e('There are no fields registered by Fewbricks.', 'fewbricks'); ?>
                                    </p>

                                    <?php

                                }

                                ?>

                            </div>

                        </div>
                    </div>

                </form>
            </div>

        </div>

        <div class="postbox">

            <h2 class="hndle">Automatically create and use PHP code</h2>

            <div class="inside">

                Use the filter <a href="https://fewbricksdocs.readme.io/v2.0/docs/auto_write_php_code_file"
                                  target="_blank">auto_write_php_code_file</a> to automatically render PHP code and
                write it to a file on each page load.
            </div>

        </div>

    </div>

</div>
