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
        echo '{"items": [';
        foreach ($this->songs as $key => $song) {
            $song->printShortJSON();
            if ($key < (count($this->songs) - 1)) {
                echo ',';
            }
        }
        echo ']';
        echo ',
        "links": [
            {
                "rel": "index",
                "uri": "<?= BASE_URL ?>"
            },
            {
                "rel": "collection",
                "uri": "<?= BASE_URL . \'songs/\' ?>"
            }
        ],
        "pagination": {
            "currentPage": 1,
            "currentItems": 2,
            "totalPages": 1,
            "totalItems": 2,
            "links": []
        }';
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