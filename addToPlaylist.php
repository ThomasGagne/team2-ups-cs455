<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require "generalFunctions.php";

$title = clean_input($_POST["title"]);
$artist = clean_input($_POST["artist"]);
$songUploader = clean_input($_POST["songUploader"]);
$playlistName = clean_input($_POST["playlistName"]);
$owner = clean_input($_POST["owner"]);

if (inputted_properly($title) and inputted_properly($artist) and inputted_properly($songUploader) and
    inputted_properly($playlistName) and inputted_properly($owner)){
    try {
        $db = new PDO("sqlite:database/noiseFactionDatabase.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check that the song we're looking for exists
        $statement = $db->prepare("select * from Song where title = ? and artist = ? and uploader = ?;");
        $result = $statement->execute(array($title, $artist, $songUploader));
        
        if (!$result) {
            throw new pdoDbException("Something's gone wrong with the prepared statement");
        }
        else if ($statement->fetch() === false) {
            // We don't necessarily need to do anything if the song didn't exist, just don't add it!
            header("Location: /viewPlaylist.php?playlistName=$playlistName&owner=$owner");
            exit();
        }

        // Get the next index for our playlist
        $statement = $db->prepare("select max(track_no) from PlaylistContainsSong where playlistName = ? and playlistOwner = ?;");
        $result = $statement->execute(array($playlistName, $owner));
        if (!$result) {
            $nextIndex = 0;
        } else {
            $nextIndex = $statement->fetch()[0] + 1;
        }

        // Actually perform the insertion
        $statement = $db->prepare("insert into PlaylistContainsSong values(?, ?, ?, ?, ?, ?);");
        $result = $statement->execute(array($title, $artist, $songUploader, $playlistName, $owner, $nextIndex));

        if (!$result) {
            // If result is false, something bad's happened.
            throw new pdoDbException("Something's gone wrong with the prepared statement");
        }

        
    } catch (PDOException $e) {
        echo "Exception: " . $e->getMessage();
    }
}

header("Location: /viewPlaylist.php?playlistName=$playlistName&owner=$owner");
exit();

?>
