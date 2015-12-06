<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';

$starringUsername = clean_input($_POST["starringUsername"]);
$title = clean_input($_POST["title"]);
$artist = clean_input($_POST["artist"]);
$uploader = clean_input($_POST["uploader"]);

try {
    $db = new PDO("sqlite:database/noiseFactionDatabase.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $db->prepare("insert into Starred values(?, ?, ?, ?);");
    $result = $statement->execute(array($title, $artist, $uploader, $starringUsername));

    if (!$result) {
        throw new pdoDbException("Something's gone wrong with the prepared statement");
    }

    $db = null;

} catch(PDOException $e) {
    echo 'Exception: '.$e->getMessage();
}
?>
