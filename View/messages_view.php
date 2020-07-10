<?php require_once __DIR__ . '/header.php'; ?>

<ul>
    <?php
        foreach($messageList as $message) {
            echo "<li><b>" . $message->id_user . "</b>     " . $message->date;
            echo "<pre>" . $message->content;
            echo "<a href=" . "index.php?rt=message/channelMessage&id_channel=" . $message->id_channel;
            echo "><button>See all messages in this chat</button></a></pre></li>";

        }
    ?>
</ul>

<?php require_once __DIR__ . '/footer.php'; ?>