<?php

/**
 * Created by IntelliJ IDEA.
 * User: Arjo
 * Date: 16-1-2016
 * Time: 15:05
 */
class CollectionResponseObject extends ResponseObject
{
    public $items,
           $pagination;



    /**
     * @return mixed
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param mixed $pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }


}