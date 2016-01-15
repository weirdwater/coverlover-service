<?php

/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 14/01/16
 * Time: 18:17
 */
class SongCollection
{
    private $songs = [];

    public function retrieveSongs()
    {
        global $db, $hades;

        try {
            $statement = $db->prepare('
                SELECT *
                FROM songs
            ');
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                array_push($this->songs, Song::fillValues($row));
            }

        }
        catch (Exception $e) {
            $hades->databaseError($e);
            exit;
        }
    }

    public function printCollectionJSON()
    {
        echo '{"Songs": [';
        foreach ($this->songs as $key => $song) {
            $song->printShortJSON();
            if ($key < (count($this->songs) - 1)) {
                echo ',';
            }
        }
        echo ']';
    }

    /**
     * @return mixed
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * @param mixed $songs
     */
    public function setSongs($songs)
    {
        $this->songs = $songs;
    }


}