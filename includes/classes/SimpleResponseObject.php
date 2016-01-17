<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 16-1-2016
 * Time: 12:18
 */
class SimpleResponseObject extends ResponseObject
{

    /**
     * @param mixed $item
     */
    public function setItem($item)
    {
        foreach ($item as $prop => $val) {
            $this->$prop = $val;
        }
    }

}