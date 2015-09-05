<?php

namespace fewbricks\helpers;

function get_real_class_name($object)
{

    $classname = get_class($object);

    if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
        $classname = $matches[1];
    }

    return $classname;

}