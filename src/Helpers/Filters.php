<?php

namespace Fewbricks\Helpers;

class Filters {

    /**
     * @return bool
     */
    public static function devModeIsEnabled()
    {

        return apply_filters('fewbricks/dev_mode', false);

    }

    /**
     * @return mixed|void
     */
    public static function fieldSnitchIsEnabled()
    {

        return apply_filters('fewbricks/dev_tools/show_fields_info', false);

    }

}
