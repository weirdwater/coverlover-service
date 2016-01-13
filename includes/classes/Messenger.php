<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 8-1-2016
 * Time: 10:21
 */
class Messenger
{
    private $log = [],
            $startApplication;

    public function __construct()
    {
        $this->startApplication = time();
    }


    public function log($message)
    {
        if (ENV === ENV_DEV) {
            //echo $message;
        }
        array_push($this->log, [ $message, time()]);
    }

    public function databaseError(Exception $e)
    {
        array_push($this->log, [ 'Exception: '.$e->getMessage() .' File: '. $e->getFile() .' Line: '. $e->getLine(), time()]);

        if (ENV === ENV_DEV) {
            //echo $message;
        }
        else {
            http_response_code(500);
            echo '{
                "code": 500,
                "message": "Database Error"
            }';
        }
    }

    public function printLog()
    {
        echo '<pre>';
        echo '['.strftime('%Y-%m-%d %H:%M:%S',$this->startApplication) .'] APPLICATION START<br/>';
        foreach ($this->log as $key => $entry)
        {
            echo $key .' [+'. ($entry[1] - $this->startApplication) .'] '. $entry[0] .'<br/>';
        }
        echo '[END APPLICATION] total ms: '. (time() - $this->startApplication);
        echo '</pre>';
    }

}