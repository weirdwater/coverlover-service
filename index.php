<?php
require 'includes/classes/Messenger.php';
$hades = new Messenger();
require 'includes/init.php';

$response = new ResponseObject();
$router = new Router();
$response = $router->route($response);
$response->printJSON();
//$hades->printLog();

?>
