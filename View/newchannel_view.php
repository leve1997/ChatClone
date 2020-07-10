<?php require_once __DIR__ . '/header.php'; ?>

<form method="POST" action="index.php?rt=channel/createResults">
    Name of your new channel:
    <input type="text" name="chname">
    <button type="submit">Submit</button>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>