<?php
require_once __DIR__ . '/../Model/chatservice.class.php';

class IndexController
{
    public function login($errorMsg)
    {
        // poziva pocetnu stranicu (kada nitko nije ulogiran)
        require_once __DIR__ . '/../View/loginpage.php';
    }

    public function loginResults()
    {
        // provjeravamo login
        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $username = $_POST['user'];
            $pass = $_POST['pass'];
            if (!empty($pass) && !preg_match('/[^a-zA-Z0-9]{1, 50}/', $username)) 
            {
                $cs = new ChatService();
                $error = $cs->checkLogIn($username, $pass);
                $_SESSION['user'] = $username;
                if ($error !== false)
                    // trebalo bi raditi i $this->login($error);
                    header('Location:index.php?rt=index/login/' . $error);
                else 
                {
                    // sve je u redu
                    unset($_GET['rt']);
                    header('Location:index.php');
                }
            }
            else 
            {
                $error = "Unos nije valjan.";
                header('Location:index.php?rt=index/login/' . $error);
            }
        }
    }

    public function index() {
        $title = "List of My Channels";
        $user = "@" . $_SESSION['user'];

        $cs = new ChatService();
        $channelList = $cs->getMyChannels($_SESSION['user']);
        if ($channelList !== false) 
        require_once __DIR__ . '/../View/index_view.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location:index.php');
    }
};
