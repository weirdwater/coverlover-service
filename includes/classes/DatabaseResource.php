<?php

/**
 * Created by PhpStorm.
 * User: Bruijnes
 * Date: 11/01/16
 * Time: 16:34
 */
class DatabaseResource
{
    private $id;
    private $table;
    public static function fromId($id)
    {
        global $db, $hades;

        if (is_numeric($id)) {
            try {

            }
            catch (Exception $e) {
                $hades->databaseError($e);
            }
        }
    }
}