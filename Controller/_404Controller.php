<?php

class _404Controller {
    function index() {
        echo "Stranica ne postoji!";

        require_once __DIR__ . "/../View/404_index.php";
    }
}

?>