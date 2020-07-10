<?php
// ako ne radi probaj prvo bez sessiona
// ili dodaj novu klasu (posebno za login, posebno za pocetnu)
session_start();
$errorMsg = false;
if (isset($_GET['rt'])) 
    $route = $_GET['rt'];
else
    $route = 'index';

if (isset($_GET['id_channel'])) {
    $id_channel = intval($_GET['id_channel'], 10);
}

$parts = explode('/', $route);
$controllerName = $parts[0] . "Controller";
if (isset($parts[1]))
    $action = $parts[1];
else
    $action = 'index';

if (isset($parts[2]))
    $errorMsg = $parts[2];

// pri pokusaju logiranja --> da bi usao u funkciju index postaviti cemo form action
// na rt=index/loginResults
if (!isset($_SESSION['user']) && $action !== 'loginResults') 
{
    $controllerName = 'indexController';
    $action = 'login';
}


// Controller $controllerName se nalazi poddirektoriju controller
$controllerFileName = 'Controller/' . $controllerName . '.php';

if( !file_exists( $controllerFileName ) )
{
	$controllerName = '_404Controller';
    $controllerFileName = 'Controller/' . $controllerName . '.php';
    $action = 'index';
}
// Includeaj tu datoteku
require_once $controllerFileName;
// Stvori pripadni kontroler
$con = new $controllerName; 
// Pozovi odgovarajuću akciju
if ($action === 'login')
    $con->$action($errorMsg);
else if ($action === 'channelMessage' || $action === 'sendMessage' || $action === 'setThumbs')
    $con->$action($id_channel);
else
    $con->$action();

?>