<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';

$artist = $_POST['artist'];
$tagArray = $_POST['tags'];
$titleArray = $_POST['titles'];
$fileArray = $_FILES['upload']['name'];

$userName = clean_input($_SESSION["username"]);   //get and clean up the username
$time = time(); //get the timestamp

//add files to the /songs/ directory
$valid_formats = array("mp3", "ogg", "wav");
$max_file_size = 1024*100000; //100 kb
$path = "songs/"; // Upload directory
$count = 0;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){

    // Loop $_FILES to add all files
    foreach ($_FILES['upload']['name'] as $f => $name) {
        
	if ($_FILES['upload']['error'][$f] == 4) {
	    continue; // Skip file if any error found
	};
        
	echo("error code: " . $_FILES['upload']['error'][$f] . " | ");
	if ($_FILES['upload']['error'][$f] == 0) {
            
	    if ($_FILES['upload']['size'][$f] > $max_file_size) {
	        $message[] = "$name is too large!.";
	        continue; // Skip large files
                
	    }
	    elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
		$message[] = "$name is not a valid format";
		continue; // Skip invalid file formats
                
	    }
	    else{ // No error found! Move uploaded files
	        if(move_uploaded_file($_FILES["upload"]["tmp_name"][$f], $path.$name)) {
                    
	            $currentTitle = $titleArray[$count];
	            $currentTagString = $tagArray[$count];
	            $explodedTags = explode(' ', $currentTagString);
                    $explodedTags = array_map("trim", $explodedTags);
                    // Delete all empty strings
                    $explodedTags = array_filter($explodedTags);
                    
	            $fileLocation = $name;
                    
	            echo("Current Title: " . $currentTitle);
	            echo("Current Tag String: " . $currentTagString);
	            echo($fileLocation);
	            var_dump($explodedTags);
                                        
	            //load the info into the database
	            try {
  		        //connect to the database
  		        $db = new PDO('sqlite:database/noiseFactionDatabase.db');
  		        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
  		        $db->exec("INSERT INTO Song (title, artist, uploader, location, uploadTimeStamp) VALUES ('$currentTitle', '$artist', '$userName', '$fileLocation', '$time')");

                        // Insert Song into the DB
                        //$statement = $db->prepare("insert into Song values(?, ?, ?, ?, ?);");
                        //$statement->execute(array($title, $artist, $username, $file_location, $time));

                        // Really hacky, but have at least 1 user star this song so it shows up in searches
                        $statement = $db->prepare("insert into Starred values ('$currentTitle', '$artist', '$userName', 'krokky');");
                        $statement->execute();
                        
                        // Add each of the tags into the Tags
                        foreach ($explodedTags as $singleTag) {
                            $statement = $db->prepare("insert into Tags select ? where not exists (select * from Tags as T where T.tagname = ?);");
                            $statement->execute(array($singleTag, $singleTag));
                            
                            // Add the tag to SongTags
                            $statement = $db->prepare("insert into SongTags values (?, ?, ?, ?);");
                            $statement->execute(array($currentTitle, $artist, $userName, $singleTag));
                        }
                        
//  		        for ($x = 0; $x < count($explodedTags); $x++) {
//			    $singleTag = $explodedTags[$x];
                            
//                            $db->exec("INSERT INTO SongTags (title, artist, uploader, TagName) VALUES ('$currentTitle', '$artist', '$userName', '$singleTag')");
//		        };
                        
		    } catch(PDOException $e) {
    		        echo 'Exception : '.$e->getMessage();
		    }
                    
	            $count++; // Number of successfully uploaded file
	            //echo("Success!");
                    
	        };
	    };
        };
    };


}
?>
