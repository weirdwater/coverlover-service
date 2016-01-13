"song" : {
    "id": "<?= $this->id ?>",
    "slug": "<?= $this->slug ?>",
    "title": "<?= $this->title ?>",
    "artist": "<?= $this->artist ?>",
    "notes": "<?= $this->notes ?>",
    "key": "<?= $this->key ?>",
    "examples": [
        <?php
        $amount_of_examples = count($this->examples);
        foreach ($this->examples as $key => $example) { ?>
            {
                "title": "<?= $example->getTitle() ?>",
                "type": "<?= $example->getType() ?>",
                "url": "<?= $example->getUrl() ?>"
            }<?php if ($key < ($amount_of_examples -1)) echo ","; ?>
        <?php } ?>
    ],
    "added": "<?= $this->added ?>"
},
"links": [
    {
        "rel": "self",
        "uri": "<?= BASE_URL . 'songs/' . $this->slug ?>"
    },
    {
    "rel": "collection",
    "uri": "<?= BASE_URL . 'songs/' ?>"
    }
]
