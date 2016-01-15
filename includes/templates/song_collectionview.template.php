{
    "id": "<?= $this->id ?>",
    "slug": "<?= $this->slug ?>",
    "title": "<?= $this->title ?>",
    "artist": "<?= $this->artist ?>",
    "added": "<?= $this->added ?>",
    "links": [
        {
            "rel": "self",
            "uri": "<?= BASE_URL . 'songs/' . $this->id ?>"
        },
        {
            "rel": "collection",
            "uri": "<?= BASE_URL . 'songs'  ?>"
        }
    ]
}