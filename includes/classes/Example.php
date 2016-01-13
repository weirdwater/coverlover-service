<?php

/**
 * Created by PhpStorm.
 * User: Arjo
 * Date: 13-1-2016
 * Time: 17:29
 */
class Example extends DatabaseResource
{
    public static $table = "examples";
    public static $id_column = "exampleId";

    private $id,
            $title,
            $type,
            $url;

    /**
     * Example constructor.
     * @param $id
     * @param $title
     * @param $type
     * @param $url
     */
    public function __construct($id, $title, $type, $url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->url = $url;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


}