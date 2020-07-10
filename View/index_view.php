<?php require_once __DIR__ . '/header.php'; ?>

<ul>
    <?php
        foreach($channelList as $channel) {
            echo "<li><a href=" . "index.php?rt=message/channelMessage&id_channel=" . $channel->id;
            echo "><p><b>" . $channel->name . "</b></p></a></li>";
        }
    ?>
</ul>

<?php require_once __DIR__ . '/footer.php'; ?>