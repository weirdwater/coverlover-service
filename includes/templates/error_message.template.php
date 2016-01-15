{
    "error": {
        "code": "<?= $code ?>",
        "message": "<?= $message ?>"
        <?php if ($hint !== null) { ?>
            ,
            "hint": "<?= $hint ?>"
        <?php } ?>
    },
    "links": [
        {
            "rel": "index",
            "url": "<?= BASE_URL ?>"
        },
        {
            "rel": "songs",
            "url": "<?= BASE_URL . 'songs' ?>"
        }
    ]
}
<?php exit ?>