<?php

require_once __DIR__ . '/../Model/chatservice.class.php';

class ChannelController {
    public function index() 
    {
        $cs = new ChatService();
        $title = "List of all available channels";
        $user = "@" . $_SESSION['user'];

        $channelList = $cs->getAllChannels();
        require_once __DIR__ . '/../View/channel_view.php';
    }

    public function createChannel() {
        $title = "Create new channel";
        $user = "@" . $_SESSION['user'];

        require_once __DIR__ . '/../View/newchannel_view.php';
    }

    public function createResults() {
        if (isset($_POST['chname'])) {
            $channelName = $_POST['chname'];
            $currUser = $_SESSION['user'];
            $cs = new ChatService();
            $cs->createNewChannel($currUser, $channelName);

            unset($_GET['rt']);
            header('Location: index.php');
        } 
    }
};

?>