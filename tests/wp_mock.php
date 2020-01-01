<?php

function apply_filters($filter) {

    switch($filter) {

        case 'fewbricks/dev_mode/enable' :
            return false;

        case 'fewbricks/info_pane/display' :
            return false;

        case 'fewbricks/exporter/auto_write_php_code_file' :
            return false;

    }

    die('Filter ' . $filter . ' not caught');

}

function is_admin() {
    return true;
}
