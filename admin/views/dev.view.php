<div class="wrap">
    <h1>Fewbricks</h1>

    <?php
    if (
        isset($_GET['fewbricks_generate_php'])
        && isset($_GET['fewbricks_field_to_php'])
        && !empty($_GET['fewbricks_field_to_php'])
        && wp_verify_nonce($_GET['_wpnonce'], 'fewbricks_generate_php_rg8392god')
    ) {

        $fieldGroupCodes = \Fewbricks\Helper::getFieldGroupsPhpCodes($_GET['fewbricks_field_to_php']);

        if (!empty($fieldGroupCodes)) {
            ?>

            <div class="acf-meta-box-wrap">
                <div class="postbox">

                    <h2 class="hndle"><?php _e('Export Field Groups', 'fewbricks'); ?></h2>

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

                                $textarea_content .= "//-------------\r";
                                $textarea_content .= "// Start of field group \"" . $data[0] . "\"\r";
                                $textarea_content .= "//-------------\r\r";

                                $textarea_content .= $data[1];

                                $textarea_content .= "\r//-------------\r";
                                $textarea_content .= "// End of field group \"" . $data[0] . "\"\r";
                                $textarea_content .= "//-------------\r\r";

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

            <h2 class="hndle">Export Fewbricks field groups and fields</h2>

            <div class="inside">

                <p>Here you can export all the field groups and fields that are registered using Fewbricks</p>
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

                                    foreach ($fieldGroupData AS $fieldGroupKey => $fieldGroupKey) {

                                        $checkboxesHtml .= '<li>';
                                        $checkboxesHtml .= '<label>';
                                        $checkboxesHtml .= '<input type="checkbox" ';
                                        $checkboxesHtml .= 'name="fewbricks_field_to_php[]" ';
                                        $checkboxesHtml .= 'value="' . $fieldGroupKey . '" ';

                                        if (isset($_GET['fewbricks_field_to_php'])
                                            && in_array($fieldGroupKey, $_GET['fewbricks_field_to_php'])
                                        ) {
                                            $checkboxesHtml .= 'checked="checked" ';
                                        }

                                        $checkboxesHtml .= '> ';
                                        $checkboxesHtml .= $fieldGroupKey;
                                        $checkboxesHtml .= '</label>';
                                        $checkboxesHtml .= '</li>';

                                    }

                                    $checkboxesHtml .= '</ul>';

                                    echo $checkboxesHtml;

                                    ?>

                                    <hr>

                                    <div class="acf-label">
                                        <label for="fewbricks_generate_php_split">Generate:</label>
                                    </div>
                                    <select name="fewbricks_generate_php_split" id="fewbricks_generate_php_split">
                                        <option value="one_per_field_group">One textearea per field group</option>
                                        <option value="no_split">One textarea with all field groups in it</option>
                                    </select>

                                    <?php submit_button('Generate PHP', 'primary', 'fewbricks_generate_php'); ?>
                                    <?php wp_nonce_field('fewbricks_generate_php_rg8392god', '_wpnonce', false); ?>
                                    <input type="hidden" name="action" value="fewbricks_generate_php" value="1"/>
                                    <input type="hidden" name="post_type" value="acf-field-group"/>
                                    <input type="hidden" name="page" value="fewbricksdev"/>

                                    <?php

                                } else {
                                    ?>

                                    There are no fields registered by Fewbricks.

                                    <?php

                                }

                                ?>

                            </div>

                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>

</div>

<?php

\Fewbricks\Helper::cleanUpAfterAdminPage();
