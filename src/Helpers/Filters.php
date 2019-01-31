<?php

namespace Fewbricks\Helpers;

class Filters {

    /**
     * @return bool
     */
    public static function dev_mode_is_enabled()
    {

        return \apply_filters('fewbricks/dev_mode', false);

    }

    /**
     * @return bool
     */
    public static function fieldSnitchIsEnabled()
    {

        return apply_filters('fewbricks/dev_tools/show_fields_info', false);

    }

}
