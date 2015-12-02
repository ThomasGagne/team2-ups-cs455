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
            <h3>Search Results:</h3>

            <?php
            $search = clean_input($_GET["searchPlaylists"]);
            if (inputted_properly($search)) {
                try {
                    $db = new PDO("sqlite:database/noiseFactionDatabase.db");
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    //////////////////////////////////////////////
                    // Form the search box's text into a SFW query
                    //////////////////////////////////////////////
                    
                    // Get an array of substrings of $search, delimited by spaces
                    $args = explode(" ", $search);
                    
                    // Go through each arg and add its condition to the query
                    $ordering = "";

                    $query = "select P.*, sum(songScore) as score from PlaylistContainsSong as P natural join (select title, artist, songUploader, count(starringUsername) as songScore from Starred group by title, artist, songUploader) ";
                    $conditions = array();
                    
                    if (count($args) === 0) {
                        $query = $query . " " . $ordering;
                        
                    } else {

                        $query = $query . " where ";
                        
                        foreach ($args as $arg) {
                            
                            if (substr($arg, 0, 1) === '-') {
                                $query = $query . "not ";
                                $arg = substr($arg, 1);
                            }
                            
                            if (substr($arg, 0, 4) === 'tag:') {
                                $tag = substr($arg, 4);
                                // Is there a better method than this?
                                array_push($conditions, "exists (select * from Playlist as P1 natural join PlaylistTags where tagName = '$tag' and P1.playlistname = P.playlistname and P1.owner = P.playlistowner) ");
                                
                            } else if (substr($arg, 0, 5) === 'user:') {
                                $user = substr($arg, 5);
                                array_push($conditions, "playlistowner = '$user' ");
                                
                            } else if (substr($arg, 0, 6) === 'order:') {
                                $order = substr($arg, 6);

                                if ($order === "score") {
                                    $ordering = "order by score desc";
                                } else if ($order === "score_asc"){
                                    $ordering = "order by score";
                                }
                            } else {
                                $arg = str_replace("*", "%", $arg);
                                array_push($conditions, "playlistname like '$arg'");
                            }

                        }

                        function joinConditions($cond1, $cond2) {
                            return $cond1 . " and " . $cond2;
                        }

                        $all_conditions = array_reduce($conditions, "joinConditions");
                        // PHP's reduce function is really weird and puts an " and " at the start
                        $all_conditions = substr($all_conditions, 5);

                        $query = $query . $all_conditions . " ";
                        // TODO: integrate the ability to change the offset of the limit
                        // use: limit 15 offset 15*pagenum
                        $query = $query . "group by playlistname, playlistowner limit 15";
                        $query = $query . $ordering . ";";
                    }

                    echo $query;

                    $statement = $db->prepare($query);
                    $result = $statement->execute();
                    
                } catch(PDOException $e) {
                    echo 'Exception: '.$e->getMessage();
                }
                
            } else {
                
            }
            ?>
        </div>

    </body>
</html>
