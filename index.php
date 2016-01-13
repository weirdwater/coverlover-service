<?php
require 'includes/classes/Messenger.php';
$hades = new Messenger();

require 'includes/init.php';

$song = Song::fromId(1);

//$hades->printLog();
?>
<pre>
    {
    <?php $song->printDetailedJSON(); ?>
    }
</pre>