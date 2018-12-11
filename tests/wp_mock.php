<?php

function apply_filters($filter) {

    switch($filter) {

        case 'fewbricks/dev_mode' :
            return false;

    }

    die('Filter ' . $filter . ' not caught');

}
