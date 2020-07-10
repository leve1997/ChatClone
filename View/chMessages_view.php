<?php require_once __DIR__ . '/header.php'; ?>

<ul>
    <?php
        foreach($messageList as $message) {
            echo "<li><b>" . $message->id_user . "</b>     " . $message->date;
            echo "<pre>" . $message->content . "<a href=" . "index.php?rt=message/setThumbs&id_channel=" . $message->id;
            echo "><img src=" . "like.png" . "><span>" . $message->thumbs_up;
            echo "</span></a></pre></li>";
        }
    ?>
</ul>
<div>
<form method="POST" action=<?php echo "index.php?rt=message/sendMessage&id_channel=" . $channelId ?> >
        <input type="text" name="msg" value="" style="width: 90%;">
        <button type="submit">Send</button>
</form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>