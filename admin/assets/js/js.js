jQuery(document).ready(function () {

    /**
     * Toggle all checkbox siblings
     */
    jQuery('[data-fewbricks-toggle-all-siblings]').on('change', function () {

        var checked = jQuery(this).prop('checked');

        jQuery(this).parents('ul:first').find('[type="checkbox"]').each(function () {

            jQuery(this).prop('checked', checked);

        });

    });

});
