<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

// Note: all paths are relative to the current page, not the DocumentRoot!
require "../generalFunctions.php";

// If we don't have a GET variable set, just redirect to the homepage.
// Maybe we can have a page which lists currently popular users?
if (!isset($_GET["user"])) {
    header("Location: /index.php");
    exit();
} else {
    $user = $_GET["user"];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("../head.html"); ?>
    </head>
    <body>

        <?php include("../header.php"); ?>
        <?php include("../noscript.html"); ?>
        
        <div class="content-center">
            <?php echo "<h3>" . $user . "'s Profile</h3>"; ?>
            <hr>
            <h3>Recently Uploaded:</h3>

            <?php
            $query = "select * from Song as S natural join (select title, artist, songUploader, count(starringUsername) as score from Starred group by title, artist, songUploader) where uploader=\"$user\" order by uploadTimeStamp desc limit 15;";

            try {
                $db = new PDO("sqlite:../database/noiseFactionDatabase.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $statement = $db->prepare($query);
                $result = $statement->execute();

                while ($row = $statement->fetch()) {
                    echo generateSongPlayer($row);
                }

            } catch(PDOException $e) {
                echo 'Exception: '.$e->getMessage();
            }
            ?>
        </div>
        
    </body>
</html>
