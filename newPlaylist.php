<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';

$playlistNameErr = $totalFailure = "";
$playlistName = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playlistName = clean_input($_POST["playlistName"]);
    $tags = clean_input($_POST["tags"]);
    $username = $_SESSION["username"];
    
    $fail = false;
    
    if (inputted_properly($playlistName)) {

        // Check if username is taken in the DB
        // In the future, we should do this differently, since our current setup can be broken
        // due to race conditions of 2 users trying to create the same name at the same time.
        try {
            $db = new PDO("sqlite:database/noiseFactionDatabase.db");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Use prepared statements rather than $db->query()
            // It makes the PDO automatically protect against SQL injection
            $statement = $db->prepare("select * from Playlist where playlistName = ? and owner = ?");
            $result = $statement->execute(array($playlistName, $username));

            if (!$result) {
                // If result is false, something bad's happened.
                throw new pdoDbException("Something's gone wrong with the prepared statement");
            } else if ($statement->fetch() !== false) {
                $playlistNameErr = "Sorry, you already have a playlist named '$playlistName'.";
                $fail = true;
            }
            
            $db = null;
            
        } catch(PDOException $e) {
            // For now, print out errors so we catch them early. In professional deployment,
            // this should NEVER be done, since it can leak vital DB information.
            // In the future, we'll need to read the exception and give the user an appropriate message.
            echo 'Exception: '.$e->getMessage();
        }

        // Make sure the playlistName only contains standard characters
        if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $playlistName)) {
            $playlistNameErr = "Sorry, your playlist name can only contain letters, numbers, and underscores!";
            $fail = true;
        }
        
        // If everything worked, then let's create a playlist
        if (!$fail) {
            try {
                $db = new PDO("sqlite:database/noiseFactionDatabase.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $statement = $db->prepare("insert into Playlist values (?, ?);");
                $result = $statement->execute(array($playlistName, $username));

                if (!$result) {
                    throw new pdoDbException("Something's gone terribly wrong :(");
                } else {
                    // Add each of the tags
                    $args = explode(" ", $tags);
                    $args = array_map("trim", $args);
                    // Delete all empty strings
                    $args = array_filter($args);
                    
                    foreach ($args as $arg) {
                        // Add the tag to Tags if it doesn't already exist
                        $statement = $db->prepare("insert into Tags select ? where not exists (select * from Tags as T where T.tagname = ?);");
                        $statement->execute(array($arg, $arg));
                        
                        // Add the entry to PlaylistTags
                        $statement = $db->prepare("insert into PlaylistTags values (?, ?, ?);");
                        $statement->execute(array($playlistName, $username, $arg));
                    }
                    
                    header("Location: viewPlaylist.php?playlistName=$playlistName&owner=$username");
                    exit();
                }

                
            } catch(PDOException $e) {
                echo 'Exception: '.$e->getMessage();
            }
            
            exit();            
        }
        
    }else {
        // Something must be empty        
        if (!inputted_properly($playlistName)) {
            $playlistNameErr = "Sorry, the playlist's name can't be empty!";
        }
        
    }
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

            <h3>Create a new playlist:</h3>
            <form method="post" action="newPlaylist.php">
                Please enter the name for this playlist:
                <br>
                Name: <input type="text" name="playlistName" value="<?php echo $playlistName;?>">
                <span class="error"><?php echo $playlistNameErr; ?></span>
                <br><br>
                Please enter a list of tags this playlist should have, space separated. See <a href="/searchHelp.php">Search Help</a> for tagging guidelines. Note that tags here do not need the "tag:" prefix like they do for searching.
                <input type="text" name="tags" size="100" value="<?php echo $tags; ?>">
                <br><br>
                <input type="submit" name="submit" value="Create Playlist"/>
            </form>
            
        </div>
        
    </body>
</html>
