<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <meta charset="utf8" lang="hr">
    <link rel="stylesheet" type="text/css" href="css/stil.css">
</head>
<body>
    <header>
    <h1><span>Chat</span><span style="float: right"><?php echo $user; ?></span></h1>
    </header>
    <ul id="horlist">
        <li id="flt"><a href="index.php?rt=index" id="menu">My Chanells</a></li>
        <li id="flt"><a href="index.php?rt=channel" id="menu">All Channels</a></li>
        <li id="flt"><a href="index.php?rt=channel/createChannel" id="menu">Start a new channel</a></li>
        <li id="flt"><a href="index.php?rt=message" id="menu">Messenger</a></li>
        <li id="flt"><a href="index.php?rt=index/logout" id="menu">Log out</a></li>
    </ul>

    <h1><?php echo $title; ?></h3>