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

    public static $table,
                  $id_column;

    public static function fromId($id)
    {
        global $db, $hades;

        if (is_numeric($id)) {
            try {
                $statement = $db->prepare("
                    SELECT *
                    FROM ?
                    WHERE ? = ?
                ");
                $statement->bindParam(1, self::$table, PDO::PARAM_STR);
                $statement->bindParam(2, self::$id_column, PDO::PARAM_STR);
                $statement->bindParam(3, $id, PDO::PARAM_INT);
                $statement->execute();
                $results = $statement->fetch(PDO::FETCH_BOTH);
            }
            catch (Exception $e) {
                $hades->databaseError($e);
            }
        }
    }
}