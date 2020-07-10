<!DOCTYPE html>
<html>
<head>
    <title>Chat - Dobrodosli!</title>
    <meta charset="utf8">
</head>
<body>
    <h1>Dobrodosli u chat aplikaciju</h1>
    <form method="POST" action='index.php?rt=index/loginResults'>
        Username:
        <input type="text" name="user"><br>
        Password:
        <input type="password" name="pass"><br>
        <button type="submit">Ulogiraj se!</button>
    </form>
    <br>
    <p>
        <?php if($errorMsg !== false) echo "Greska: " . $errorMsg; ?>
    </p>
    
</body>
</html>