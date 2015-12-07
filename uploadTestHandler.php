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

//var_dump($fileArray);
//echo(" ");
//var_dump($titleArray);
//var_dump($tagArray);
//echo(" ");
//echo($tagArray);
//echo $albumName . " " . $artist;


//add files to the /songs/ directory

$valid_formats = array("mp3", "ogg", "wav");
$max_file_size = 1024*100000; //100 kb
$path = "songs/"; // Upload directory
$count = 0;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	//echo("Success 1!");
	// Loop $_FILES to exeicute all files
	foreach ($_FILES['upload']['name'] as $f => $name) {
	    //echo("Success: " . $name);
	    if ($_FILES['upload']['error'][$f] == 4) {
	        //echo("Fail 1!");
	        continue; // Skip file if any error found
	    };
	    //echo("Made it here");
	    echo("error code: " . $_FILES['upload']['error'][$f] . " | ");
	    if ($_FILES['upload']['error'][$f] == 0) {
	    		//echo("Success 2!");
	        if ($_FILES['upload']['size'][$f] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large files
	        	//echo("error: " . $message);
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
				//echo("error: " . $message);
			}
	        else{ // No error found! Move uploaded files
	            if(move_uploaded_file($_FILES["upload"]["tmp_name"][$f], $path.$name))

	            $currentTitle = $titleArray[$count];
	        	$currentTagString = $tagArray[$count];
	        	$explodedTags = explode(' ', $currentTagString);
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

  					for ($x = 0; $x < count($explodedTags); $x++) {
						$singleTag = $explodedTags[$x];

            $db->exec("INSERT INTO SongTags (title, artist, uploader, TagName) VALUES ('$currentTitle', '$artist', '$userName', '$singleTag')");
					  };

				} catch(PDOException $e) {
    				echo 'Exception : '.$e->getMessage();
				}







	            $count++; // Number of successfully uploaded file
	        	//echo("Success!");








	        };
	    };
	};
};




?>
