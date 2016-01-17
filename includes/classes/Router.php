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
                'POST'    => 'songDetailPost',
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
        if ($_SERVER['HTTP_ACCEPT'] !== 'application/json')
            return $this->errorMessage($response, 406, 'Not Acceptable', 'The service currently only supports application/json.');
        else {
            header('Content-Type : application/json');
        }

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
        foreach ($this->routes as $resource => $simple)
            $response->addLink($resource, BASE_URL . $resource);
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
        return $response;
    }

    public function songDetailPost($response, $id)
    {
        return $response;
    }

    public function songDetailPut($response, $id)
    {
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
        $pages = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);

        $songs = new SongCollection($limit, $pages);
        $songs->retrieveSongs();
        $response->setItems($songs->getResponseItems());
        $response->setPagination($songs->getPagination());
        $response->addLink('self', BASE_URL . 'songs');
        return $response;
    }

    public function songCollectionPost($response)
    {
        return $response;
    }

    public function options($resource, $is_simple)
    {
        $options = implode(',', array_keys($this->routes[$resource][$is_simple]));
        header('Allow : ' . $options);
        exit;
    }
}