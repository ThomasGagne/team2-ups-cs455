<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

require "generalFunctions.php";

if (!isset($_GET["playlistName"]) or !isset($_GET["owner"])) {
    header("Location: /index.php");
    exit();
} else {
    $playlistName = $_GET["playlistName"];
    $owner = $_GET["owner"];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("head.html"); ?>
    </head>
    <body>

        <?php include("header.php"); ?>
        <?php include("noscript.html"); ?>
        
        <div class="content-center">
            <div>
            <?php echo "<h2>" . $playlistName . "</h2>"; ?>
            <?php echo "Uploaded by: <a href='/account/index.php?user=$owner'>" . $owner . "</a>"; ?>
            <hr>

            <?php
            $query = "select * from PlaylistContainsSong where playlistName = ? and playlistOwner = ? order by track_no;";

            try {
                $db = new PDO("sqlite:database/noiseFactionDatabase.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $statement = $db->prepare($query);
                $result = $statement->execute(array($playlistName, $owner));

                $anything = false;
                
                while ($row = $statement->fetch()) {
                    $anything = true;
                    echo generateSongPlayerFromPK($row["title"], $row["artist"], $row["songUploader"]);
                }

                if (!$anything) {
                    echo "There doesn't seem to be anything here!";
                }

            } catch(PDOException $e) {
                echo 'Exception: '.$e->getMessage();
            }
            ?>
            </div>
            <hr>
            <?php
            if ($_SESSION["username"] === $owner) {
                echo "Add a song to $playlistName:";
                echo "<form method='post' action='addToPlaylist.php'>";
                echo "Song title: <input type='text' name='title'><br>";
                echo "Song artist: <input type='text' name='artist'><br>";
                echo "Song uploader: <input type='text' name='songUploader'><br>";
                echo "<input type='text' name='playlistName' value='$playlistName' hidden='true'>";
                echo "<input type='text' name='owner' value='$owner' hidden='true'>";
                echo "<input type='submit' name='submit' value='Add Song'></form>";
            }
            ?>
        </div>
        
    </body>
</html>
