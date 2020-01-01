<?php

function apply_filters($filter) {

    switch($filter) {

        case 'fewbricks/dev_mode/enable' :
            return false;

        case 'fewbricks/info_pane/display' :
            return false;

        case 'fewbricks/exporter/php/auto_write_target' :
            return false;

    }

    die('Filter ' . $filter . ' not caught');

}

function is_admin() {
    return true;
}
