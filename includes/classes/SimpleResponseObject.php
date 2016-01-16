<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 16-1-2016
 * Time: 12:18
 */
class SimpleResponseObject extends ResponseObject
{
    public $item;

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

}