<?php

/**
 * Created by PhpStorm.
 * User: Arjo
 * Date: 13-1-2016
 * Time: 17:28
 */
class Song extends DatabaseResource
{
    public static $table = "songs";
    public static $id_column = "songId";

    private $id,
            $slug,
            $title,
            $artist,
            $notes,
            $key,
            $added,
            $examples = [];

    /**
     * Song constructor.
     * @param $id
     * @param $slug
     * @param $title
     * @param $artist
     * @param $notes
     * @param $key
     * @param $added
     * @param array $examples
     */
    public function __construct($id, $slug, $title, $artist, $notes, $key, $added, array $examples)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
        $this->artist = $artist;
        $this->notes = $notes;
        $this->key = $key;
        $this->added = $added;
        $this->examples = $examples;
    }

    public static function fillValues(array $pdoValues)
    {
        $id = $pdoValues['songId'];
        $slug = $pdoValues['slug'];
        $title = $pdoValues['title'];
        $artist = $pdoValues['artist'];
        $notes = $pdoValues['notes'];
        $key = $pdoValues['key'];
        $added = $pdoValues['added'];
        $examples = [];

        $pdoExamples = self::fetchExamples($id);
        foreach($pdoExamples as $example) {
            array_push($examples, new Example($example['exampleId'], $example['title'], $example['type'], $example['url']));
        }

        return new self($id, $slug, $title, $artist, $notes, $key, $added, $examples);
    }

    public static function fromId($id, $table = null, $id_column = null)
    {
        $results = parent::fromId($id, self::$table, self::$id_column); // TODO: Change the autogenerated stub
        return self::fillValues($results);
    }

    public static function fromSlug($slug)
    {
        global $db, $hades;


        try {
            $statement = $db->prepare('
                SELECT *
                FROM `songs`
                WHERE `slug` = ?
            ');
            $statement->bindParam(1, $slug, PDO::PARAM_STR);
            $statement->execute();
            $results = $statement->fetch(PDO::FETCH_ASSOC);

            return self::fillValues($results);
        }
        catch (Exception $e) {
            $hades->databaseError($e);
        }

    }

    public static function fetchExamples($songId)
    {
        global $db, $hades;

        if (is_numeric($songId)) {
            try {
                $statement = $db->prepare("
                    SELECT *
                    FROM examples
                    WHERE songId = ?
                ");
                $statement->bindParam(1, $songId, PDO::PARAM_INT);
                $statement->execute();
                $results = $statement->fetchAll(PDO::FETCH_BOTH);

                return $results;
            }
            catch (Exception $e) {
                $hades->databaseError($e);
            }
        }
    }

    public function getResponseItem($detailed = false)
    {
        $song = new stdClass();
        $song->id = $this->id;
        $song->slug = $this->slug;
        $song->title = $this->title;
        $song->artist = $this->artist;
        if ($detailed) {
            $song->notes = $this->notes;
            $song->key = $this->key;
            $song->examples = $this->examples;
        }
        else {
            $song->links = [
                ResponseObject::generateLink('self', BASE_URL . 'songs/' . $this->slug),
                ResponseObject::generateLink('collection', BASE_URL . 'songs')
            ];
        }
        $song->added = $this->added;

        return $song;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getExamples()
    {
        return $this->examples;
    }

    /**
     * @param array $examples
     */
    public function setExamples($examples)
    {
        $this->examples = $examples;
    }
}