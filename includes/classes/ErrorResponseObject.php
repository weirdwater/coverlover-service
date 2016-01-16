<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 16-1-2016
 * Time: 15:09
 */
class ErrorResponseObject extends ResponseObject
{
    public $error;

    /**
     * ErrorResponseObject constructor.
     * @param $error
     */
    public function __construct($code, $message, $hint = null)
    {
        parent::__construct();
        $this->setStatusCode($code);
        $this->error = new stdClass();
        $this->error->code    = $code;
        $this->error->message = $message;
        if ($hint !== null)
        {
            $this->error->hint = $hint;
        }
    }



}