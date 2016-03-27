<?php

namespace fewbricks\helpers;

/**
 * Get the name of the class of an object without namspaces.
 * @param $object
 * @return mixed
 */
function get_real_class_name($object)
{

    $classname = get_class($object);

    if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
        $classname = $matches[1];
    }

    return $classname;

}