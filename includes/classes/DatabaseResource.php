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

    public static function fromId($id, $table, $id_column)
    {

        global $db, $hades;

        if (is_numeric($id)) {
            try {
                $statement = $db->prepare('
                    SELECT *
                    FROM '. $table .'
                    WHERE '. $id_column .' = ?
                ');
                $statement->bindParam(1, $id, PDO::PARAM_INT);
                $statement->execute();
                $results = $statement->fetch(PDO::FETCH_ASSOC);

                return $results;
            }
            catch (Exception $e) {
                $hades->databaseError($e);
            }
        }
    }

    public static function fillValues(array $pdoValues)
    {
        return new self();
    }
}