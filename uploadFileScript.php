<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';

try {
  //connect to the database
  $db = new PDO('sqlite:database/airport.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Exception : '.$e->getMessage();
}

//getting the song info and files from $_POST
$title[] = clean_input($_POST['title[]']); //array of titles
$artist = clean_input($_POST['artist']); //artist of the songs
$tags[] = $_POST['tags[]'];  //an array of strings of tags (multiple tags in one string)
$files[] = $_POST['files[]']; //array of song files to upload

$userName = clean_input($_SESSION["username"]);   //get and clean up the username
$time = time(); //get the timestamp

$target_dir = "songs/"; //directory to save the song file


for ($x = 0; $x < count($files[]); $x++) {
  $target_file = $target_dir . basename($_FILES["$x"]["name"]); //creating a file path to save the file to (target directory + filename + extension)
  $uploadOk = 1;  //if it is ok or not to upload the file (0 = not ok, 1 = ok)
  $fileType = pathinfo($target_file, PATHINFO_EXTENSION); //the type of the file being uploaded



  //Check if the file already exists in the directory
  if (file_exists($target_file)) {
    echo "Sorry, the file already exists";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "mp3" && $imageFileType != "wav" $$ $imageFileType != "ogg") {
    echo "Sorry, only MP3, WAV, & OGG files extensions are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      //if the file is sucessfully uploaded to the server
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        //get the location of the file
        $file_location = basename($target_file);

        //turn the string of tags for this file into an array of individual tags
        $listOfTags = explode(' ', $tags[$x]);


        // if the file was uploaded to the directory, add the info to the database
        try {

            foreach ($listOfTags as $singleTag) {
            $db->exec("
              INSERT into SongTags
                title = '$title',
                artist = '$artist',
                uploader = '$userName',
                tagName = '$singleTag'
              ");
            };

          //insert song info into database
          $db->exec("
              INSERT into Song
                title = '$title',
                artist = '$artist',
                uploader = '$username',
                location = '$file_location',
                uploadTimeStamp = '$time'
          ");
        } catch(PDOException $e) {
      		  echo 'Exception : '.$e->getMessage();
      	}
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
  }
}
?>
