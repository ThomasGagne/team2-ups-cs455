<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';

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

            <?php
            echo "<h3>Search Results For: \"" . $_GET["searchPlaylists"] . "\"</h3>";
            echo "<span>";
            
            $search = clean_input($_GET["searchPlaylists"]);

            if (isset($_GET["offset"])) {
                $offset = clean_input($_GET["offset"]);
            } else {
                $offset = "0";
            }

            printPageNavigation($offset);
            echo "</span><br>";

            //////////////////////////////////////////////
            // Form the search box's text into a SFW query
            //////////////////////////////////////////////
            
            // Get an array of substrings of $search, delimited by spaces
            $args = explode(" ", $search);
            $args = array_map("trim", $args);
            // Delete all empty strings
            $args = array_filter($args);
            
            $ordering = ""; // Need to figure this out, maybe change the database?
            
            //$query = "select playlistName, playlistOwner, sum(songScore) as score from PlaylistContainsSong as P natural join (select title, artist, songUploader, count(starringUsername) - 1 as songScore from Starred group by title, artist, songUploader) ";
            $query = "select * from playlist as P where exists (select * from Account as A where A.username = P.owner and A.private = 'false') ";
            $conditions = array();
            
            if (count($args) !== 0) {
                
                $addedAnd = false;
                
                foreach ($args as $arg) {

                    $not = "";

                    if (substr($arg, 0, 1) === '-') {
                        $not = " not ";
                        $arg = substr($arg, 1);
                    }
                    
                    if (substr($arg, 0, 4) === 'tag:') {
                        $tag = substr($arg, 4);
                        // Is there a better method than this?
                        array_push($conditions, "$not exists (select * from Playlist as P1 natural join PlaylistTags where tagName = '$tag' and P1.playlistname = P.playlistname and P1.owner = P.owner) ");
                        
                    } else if (substr($arg, 0, 5) === 'user:') {
                        $user = substr($arg, 5);
                        array_push($conditions, "$not owner = '$user' ");
                        
                    } else {
                        $arg = str_replace("*", "%", $arg);
                        array_push($conditions, "$not playlistname like '$arg'");
                    }
                    
                }
                
                function joinConditions($cond1, $cond2) {
                    return $cond1 . " and " . $cond2;
                }
                
                $all_conditions = array_reduce($conditions, "joinConditions");
                // PHP's reduce function is really weird and puts an " and " at the start
                $all_conditions = substr($all_conditions, 5);

                if (inputted_properly($all_conditions)) {
                    $query = $query . " and " . $all_conditions . " ";
                }
                
            }

            //$query = $query . "group by playlistname, playlistowner limit $offset, 10";
            $query = $query . "limit $offset, 10 ";
            $query = $query . " " . $ordering . ";";

            try {
                $db = new PDO("sqlite:database/noiseFactionDatabase.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $statement = $db->prepare($query);
                $result = $statement->execute();

                while ($row = $statement->fetch()) {
                    echo generatePlaylistSearch($row);
                }

            } catch(PDOException $e) {
                echo 'Exception: '.$e->getMessage();
            }
            
            echo $query;
            ?>
        </div>

    </body>
</html>
