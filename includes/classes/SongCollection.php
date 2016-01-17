<?php

/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 14/01/16
 * Time: 18:17
 */
class SongCollection
{
    private $songs = [],
            $page,
            $itemsPerPage,
            $totalItems,
            $totalPages;

    /**
     * SongCollection constructor.
     * @param $page
     * @param $itemsPerPage
     */
    public function __construct($itemsPerPage = 0, $page = 1)
    {
        if ($page < 1)
            $page = 1;
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
    }


    public function retrieveSongs()
    {
        global $db, $hades;

        if ($this->itemsPerPage > 0) {
            $modifier = $this->page - 1;
            $offset = $modifier * $this->itemsPerPage;
            $limit = 'LIMIT '. $offset .', '. $this->itemsPerPage;
        }
        else {
            $limit = '';
        }

        try {
            $statement = $db->prepare('
                SELECT *
                FROM songs '.
                $limit
            );
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                array_push($this->songs, Song::fillValues($row));
            }

            $total = $db->query('
                SELECT *
                FROM songs
            ');
            $this->totalItems = $total->rowCount();

        }
        catch (Exception $e) {
            $hades->databaseError($e);
            exit;
        }
    }

    public function getResponseItems()
    {
        $items = [];
        foreach ($this->songs as $song) {
            array_push($items, $song->getResponseItem());
        }
        return $items;
    }

    public function getPagination()
    {
        $links = [];
        if ($this->itemsPerPage == 0)
            $totalpages = 1;
        else
            $totalpages = ceil($this->totalItems / $this->itemsPerPage);
        $query = 'songs?limit='. $this->itemsPerPage .'&start=';

        // First
        array_push($links, ResponseObject::generateLink(
            'first',
            BASE_URL . $query . 1
        ));
        $links[0]->page = 1;

        // Last
        array_push($links, ResponseObject::generateLink(
            'last',
            BASE_URL . $query . $totalpages
        ));
        $links[1]->page = $totalpages;

        // Previous
        if ($this->page <= 1)
            $prevPage = 1;
        else
            $prevPage = $this->page - 1;
        array_push($links, ResponseObject::generateLink(
            'previous',
            BASE_URL . $query . $prevPage
        ));
        $links[2]->page = $prevPage;

        // Next
        if ($this->page >= $totalpages)
            $nextPage = $totalpages;
        else
            $nextPage = $this->page + 1;
        array_push($links, ResponseObject::generateLink(
            'next',
            BASE_URL . $query . $nextPage
        ));
        $links[3]->page = $nextPage;


        $pagination = new stdClass();
        $pagination->currentPage = $this->page;
        $pagination->currentItems = count($this->songs);
        $pagination->totalItems = $this->totalItems;
        $pagination->totalPages = $totalpages;
        $pagination->links = $links;

        return $pagination;
    }

    /**
     * @return mixed
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * @param mixed $songs
     */
    public function setSongs($songs)
    {
        $this->songs = $songs;
    }


}