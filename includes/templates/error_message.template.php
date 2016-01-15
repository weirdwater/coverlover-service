{
    "error": {
        "code": "<?= $code ?>",
        "message": "<?= $message ?>"
        <?php if ($hint !== null) { ?>
        ,
        "hint": "<?= $hint ?>"
<?php } ?>
    }
}
<?php exit ?>