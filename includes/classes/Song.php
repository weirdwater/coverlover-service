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