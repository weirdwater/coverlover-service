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
        global $hades;
        $hades->log('Index route followed.');
        require TEMPLATES . 'index.template.php';
        exit;
    }

    public function errorMessage($code, $message, $hint = null)
    {
        global $hades;
        $hades->log('Error message route invoked.');
        require TEMPLATES . 'error_message.template.php';
    }

    public function songDetailGet($id)
    {
        global $hades;
        $hades->log('Get Song detail('. $id .') route followed.');
        $song = Song::fromId($id);
        $song->printDetailedJSON();
    }

    public function songDetailPost($id)
    {
        global $hades;
        $hades->log('Post Song detail('. $id .') route followed.');
    }

    public function songDetailPut($id)
    {
        global $hades;
        $hades->log('Put Song detail('. $id .') route followed.');
    }

    public function songDetailDelete($id)
    {
        global $hades;
        $hades->log('Delete Song detail('. $id .') route followed.');
    }

    public function songCollectionGet()
    {
        global $hades;
        $hades->log('Get Song collection route followed.');
        $collection = new SongCollection();
        $hades->log('Song Collection object created.');
        $collection->retrieveSongs();
        $hades->log('Songs Retrieved.');
        $collection->printCollectionJSON();
        $hades->log('Printed JSON.');
    }

    public function songCollectionPost()
    {
        global $hades;
        $hades->log('Post Song collection route followed.');
    }
}