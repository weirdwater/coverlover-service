<?php

/**
 * Created by PhpStorm.
 * User: Bruijnes
 * Date: 12/01/16
 * Time: 10:25
 */
class ClassLoader
{
    public static function loadClassesFromJSON($classes_file_location)
    {
        global $hades;

        $classes_raw = file_get_contents($classes_file_location);
        $classes = json_decode($classes_raw);

        foreach ($classes as $class) {
            require CLASSES . $class->file;
            $hades->log('loaded class '. $class->class);
        }
    }
}