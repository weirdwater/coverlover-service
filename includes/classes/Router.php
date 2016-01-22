<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 13-1-2016
 * Time: 20:22
 */

class Router
{
    private $routes = [
        'songs' => [
            true  => [
                'GET'     => 'songDetailGet',
                'PUT'     => 'songDetailPut',
                'DELETE'  => 'songDetailDelete',
                'OPTIONS' => true,
            ],
            false => [
                'GET'     => 'songCollectionGet',
                'POST'    => 'songCollectionPost',
                'OPTIONS' => true
            ],
        ]
    ];

    public function route($response)
    {
        if ($_SERVER['HTTP_ACCEPT'] !== 'application/json' && $_SERVER['HTTP_ACCEPT'] !== 'application/xml')
            return $this->errorMessage($response, 406, 'Not Acceptable', 'The service currently only supports application/json and application/xml.');

        if (isset($_GET['resource'])) {
            $resource = $_GET['resource'];
            // Non-existent resource
            if (!isset($this->routes[$resource]))
                return $this->errorMessage($response, 404, "Resource doesn't exist");

            // Simple Resource
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
                    $this->options($resource, true);

                $action = $this->routes[$resource][true][$_SERVER['REQUEST_METHOD']];
                return $this->$action($response, $id);
            }
            // Collection Resource
            else {
                if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
                    $this->options($resource, false);
                if(!isset($this->routes[$resource][false][$_SERVER['REQUEST_METHOD']])) {
                    return $this->errorMessage($response, 405, 'Method Not Allowed');
                }
                else
                    $action = $this->routes[$resource][false][$_SERVER['REQUEST_METHOD']];
                return $this->$action($response);
            }
        }
        // No resource specified
        else {
            return $this->index($response);
        }
    }

    public function index(ResponseObject $response)
    {
        foreach ($this->routes as $resource => $simple) {
            $response->addLink($resource, BASE_URL . $resource);
            $response->setRootElementName('Index');
        }
        return $response;
    }

    public function errorMessage($response, $code, $message, $hint = null)
    {
        $response = new ErrorResponseObject($code, $message, $hint);
        return $response;
    }

    public function songDetailGet($response, $id)
    {
        if(is_numeric($id))
            $song = Song::fromId($id);
        else
            $song = Song::fromSlug($id);
        $response = new SimpleResponseObject();
        $response->setItem($song->getResponseItem(true));
        $response->addLink('collection', BASE_URL . 'songs');
        $response->addLink('self', BASE_URL . 'songs/' . $song->getSlug());
        $response->setRootElementName('Song');
        return $response;
    }

    public function songDetailPost($response, $id)
    {
        return $response;
    }

    public function songDetailPut($response, $id)
    {
        if(is_numeric($id))
            $song = Song::fromId($id);
        else
            $song = Song::fromSlug($id);

        switch ($_SERVER['CONTENT_TYPE']) {
            case 'application/json':
                $raw_JSON = file_get_contents('php://input');
                $input = json_decode($raw_JSON);
                $artist = $input->artist;
                $title = $input->title;
                $key = $input->key;
                $notes = $input->notes;

                break;
            case 'application/xml':
                // TODO: Accept xml post
                break;
            default:
                $response = $this->errorMessage($response, 415, 'Unsupported Content Type');
                return $response;
        }

        $fields = [
            'artist' => 0,
            'title'  => 0,
            'key'    => 0,
            'notes'  => 0
        ];

        foreach ($fields as $name => $empty) {
            if (!empty($$name)) {
                $fields[$name] = 1;
            }
        }
        if (array_sum($fields) === 0 || array_sum($fields) < count($fields)) {
            $response = new ErrorResponseObject(400, 'Bad Request', 'One or more fields are empty.');
            return $response;
        }

        if ($fields['artist'] === 1)
            $song->setArtist($artist);
        if ($fields['title'] === 1)
            $song->setTitle($title);
        if ($fields['key'] === 1)
            $song->setKey($key);
        if ($fields['notes'] === 1)
            $song->setNotes($notes);

        $song->saveChanges();

        $response = new SimpleResponseObject();
        $response->setItem($song->getResponseItem(true));
        return $response;
    }

    public function songDetailDelete($response, $id)
    {
        return $response;
    }

    public function songCollectionGet($response)
    {
        $response = new CollectionResponseObject();

        $limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_NUMBER_INT);
        $pages = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT);

        $songs = new SongCollection($limit, $pages);
        $songs->retrieveSongs();
        $response->setItems($songs->getResponseItems());
        $response->setPagination($songs->getPagination());
        $response->addLink('self', BASE_URL . 'songs');
        $response->setRootElementName('Songs');
        return $response;
    }

    public function songCollectionPost($response)
    {
        switch ($_SERVER['CONTENT_TYPE']) {
            case 'application/x-www-form-urlencoded':
                $artist = filter_input(INPUT_POST, 'artist', FILTER_SANITIZE_STRING);
                $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
                $key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
                $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
                $examples = [];
                break;
            case 'application/json':
                $raw_JSON = file_get_contents('php://input');
                $input = json_decode($raw_JSON);
                $artist = $input->artist;
                $title = $input->title;
                $key = $input->key;
                $notes = $input->notes;
                $examples = $input->examples;

                break;
            case 'application/xml':
                // TODO: Accept xml post
                break;
            default:
                $response = $this->errorMessage($response, 415, 'Unsupported Content Type');
                return $response;
        }

        $fields = [
            'artist' => 0,
            'title'  => 0,
            'key'    => 0,
            'notes'  => 0
        ];

        foreach ($fields as $name => $empty) {
            if (!empty($$name)) {
                $fields[$name] = 1;
            }
        }
        if (array_sum($fields) === 0) {
            $response = new ErrorResponseObject(400, 'Bad Request', 'All fields are empty');
            return $response;
        }

        $exampleObjs = [];
        foreach ($examples as $example) {
            array_push($exampleObjs, new Example(
                null,
                $example->title,
                $example->type,
                $example->url
            ));
        }

        $song = Song::createNewRecord($artist, $title, $key, $notes, $exampleObjs);
        $response = new SimpleResponseObject(201);
        $response->setItem($song->getResponseItem(true));
        $response->addLink('collection', BASE_URL . 'songs');
        $response->addLink('self', BASE_URL . 'songs/' . $song->getSlug());
        return $response;
    }

    public function options($resource, $is_simple)
    {
        $options = implode(',', array_keys($this->routes[$resource][$is_simple]));
        header('Allow : ' . $options);
        exit;
    }
}