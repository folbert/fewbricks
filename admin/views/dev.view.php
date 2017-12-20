<div class="wrap">
    <h1>Fewbricks</h1>

    <?php
    $code = \Fewbricks\Admin::getPhpCode();

    if (!empty($code)) {
        ?>

        <div class="acf-meta-box-wrap">
            <div class="postbox">

                <h2 class="hndle">PHP export</h2>

                <div class="inside">

                    <textarea readonly class="fewbricks__export-textarea"><?php echo $code; ?></textarea>

                </div>

            </div>

        </div>

        <?php
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

                                    $checkboxesHtml .= '<li><label><input type="checkbox" class="acf-checkbox-toggle"> '
                                                       . __('Toggle all', 'fewbricks') . '</li>';

                                    foreach ($fieldGroupData AS $fieldGroupKey => $fieldGroupTitle) {

                                        $checkboxesHtml .= '<li>';
                                        $checkboxesHtml .= '<label>';
                                        $checkboxesHtml .= '<input type="checkbox" name="fewbricks_field_to_php[]" value="'
                                                           .
                                                           $fieldGroupKey . '"> ';
                                        $checkboxesHtml .= $fieldGroupTitle;
                                        $checkboxesHtml .= '</label>';
                                        $checkboxesHtml .= '</li>';

                                    }

                                    $checkboxesHtml .= '</ul>';

                                    echo $checkboxesHtml;

                                    ?>

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
