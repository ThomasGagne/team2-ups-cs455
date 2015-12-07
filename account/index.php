<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

// Note: all paths are relative to the current page, not the DocumentRoot!
require_once "../generalFunctions.php";


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
        <?php include("privacyPage.php"); ?>

        <div class="content-center">
            <?php echo "<h3>" . $user . "'s Profile</h3>"; ?>
            <?php
            if (isset($_SESSION["username"]) and $_SESSION["username"] == $user) {

                echo "<form action='privacyPage.php' method='post' class='dropdown' size='20'>";
                echo "<select name='privacy'>";
                echo "<option value='Public'>Public</option>";
                echo "<option value='Private'>Private</option>";
                echo "</select>";
                echo "<input type='submit' style='font-size: 12px;' size='20' value='Apply setting'/>";
                echo "</form>";

                try {
                    $db = new PDO("sqlite:../database/noiseFactionDatabase.db");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $statement = $db->prepare("Select * from Account where username='$user';");
                    $result = $statement->execute();
                    $private = $statement->fetch()["private"];
                    
                    if ($private === "true") {
        	        $isPrivate = "Private";
		    } else {
		        $isPrivate = "Public";
		    }
                    
                    $db = null;
                    
                } catch(PDOException $e) {
                    echo 'Exception: '.$e->getMessage();
                }

                echo "Current privacy setting: " . $isPrivate;
            }

            ?>
            
            <hr>
            <h3>Recently Uploaded:</h3>

            <?php
            $query = "select * from Song as S natural join (select title, artist, songUploader, count(starringUsername) - 1 as score from Starred group by title, artist, songUploader) where uploader=\"$user\" order by uploadTimeStamp desc limit 15;";

            try {
                $db = new PDO("sqlite:../database/noiseFactionDatabase.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $statement = $db->prepare($query);
                $result = $statement->execute();

                $something = false;
                while ($row = $statement->fetch()) {
                    $something = true;
                    echo generateSongPlayer($row);
                }

            } catch(PDOException $e) {
                echo 'Exception: '.$e->getMessage();
            }

            if (!$something) {
                echo "There doesn't appear to be anything here!";
            }
            ?>

            <hr>

            <h3><?php echo $user;?>'s Playlists:</h3>

            <?php
            $query = "select * from playlist where owner = ?;";
            //$query = "select playlistName, playlistOwner, sum(songScore) as score from PlaylistContainsSong as P natural join (select title, artist, songUploader, count(starringUsername) - 1 as songScore from Starred group by title, artist, songUploader) where playlistOwner = ?";

            try {
                $db = new PDO("sqlite:../database/noiseFactionDatabase.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $statement = $db->prepare($query);
                $result = $statement->execute(array($user));

                $something = false;
                while ($row = $statement->fetch()) {
                    $something = true;
                    echo generatePlaylistSearch($row);
                }
 
            } catch(PDOException $e) {
                echo 'Exception: '.$e->getMessage();
            }

            if (!$something) {
                echo "There doesn't appear to be anything here!";
            }
            
            ?>
        </div>
        
    </body>
</html>
