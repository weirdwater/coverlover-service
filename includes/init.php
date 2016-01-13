<?php
$hades->log('loaded init.php');
require 'settings.php';

// Load classes
require CLASSES . 'ClassLoader.php';
ClassLoader::loadClassesFromJSON(ROOT_PATH . 'includes/classes.json');

// Connect to the database
try
{
    $db = new PDO(
        'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME,
        DB_USER,
        DB_PASS
    );
    // We can set up custom error handling by catching thrown exceptions.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES \'utf8\'');
}
catch (PDOException $e)
{
    $hades->databaseError($e);
    $hades->printLog();
    exit;
}
$hades->log('Successfully accessed the database '. DB_NAME);

