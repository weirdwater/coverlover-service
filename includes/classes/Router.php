<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 13-1-2016
 * Time: 20:22
 */

class Router
{

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $id = null;

        $routes = [
            'songs' => [
                true  => [
                    'GET'    => 'songDetailGet',
                    'POST'   => 'songDetailPost',
                    'PUT'    => 'songDetailPut',
                    'DELETE' => 'songDetailDelete'
                ],
                false => [
                    'GET'    => 'songCollectionGet',
                    'POST'   => 'songCollectionPost'
                ],
            ]
        ];

        if (isset($_GET['resource'])) {
            $resource = $_GET['resource'];
            // Non-existent resource
            if (!isset($routes[$resource]))
                $this->errorMessage(404, "Resource doesn't exist");

            // Simple Resource
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $action = $routes[$resource][true][$_SERVER['REQUEST_METHOD']];
                $this->$action($id);
            }
            // Collection Resource
            else {
                $action = $routes[$resource][false][$_SERVER['REQUEST_METHOD']];
                $this->$action();
            }
        }
        // No resource specified
        else {
            $this->index();
        }

    }

    public function index()
    {
        require TEMPLATES . 'index.template.php';
        exit;
    }

    public function errorMessage($code, $message, $hint = null)
    {
        require TEMPLATES . 'error_message.template.php';
    }

    public function songDetailGet($id)
    {
        $song = Song::fromId(1);
        $song->printDetailedJSON();
    }

    public function songDetailPost($id) {}

    public function songDetailPut($id) {}

    public function songDetailDelete($id) {}

    public function songCollectionGet() {}

    public function songCollectionPost() {}
}