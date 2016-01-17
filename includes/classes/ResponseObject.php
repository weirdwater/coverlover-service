<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 16-1-2016
 * Time: 12:18
 */
class ResponseObject
{
    private $statusCode;

    public $links = [];

    /**
     * ResponseObject constructor.
     * @param $statusCode
     */
    public function __construct($statusCode = 200)
    {
        $this->statusCode = $statusCode;
        $this->addLink('index', BASE_URL);
    }


    public function printJSON()
    {
        http_response_code($this->statusCode);
        header('Content-Type : application/json');
        echo json_encode($this);
    }

    public function printXML()
    {
        http_response_code($this->statusCode);
        header('Content-Type : application/xml');
        // TODO: print XML
        echo "Should be printing XML <br /><pre>";
        var_dump($this);
        echo '<pre>';
    }

    public function addLink($rel, $url)
    {
        array_push($this->links, self::generateLink($rel, $url));
    }

    public static function generateLink($rel, $url)
    {
        $link = new stdClass();
        $link->rel = $rel;
        $link->href = $url;
        return $link;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }


}