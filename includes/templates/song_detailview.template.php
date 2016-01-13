{
    "id": "<?= $this->id ?>",
    "slug": "<?= $this->slug ?>",
    "title": "<?= $this->title ?>",
    "artist": "<?= $this->artist ?>",
    "notes": "<?= $this->notes ?>",
    "key": "<?= $this->key ?>",
    "examples": [
        <?php foreach ($this->examples as $example) ?>
            {
                "title": "<?= $example->title ?>",
                "type": "<?= $example->type ?>",
                "url": "<?= $example->url ?>"

            }
    ],
    "added": "<?= $this->added ?>",
}
