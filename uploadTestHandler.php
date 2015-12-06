<?php

$albumName = $_POST['album'];
$artist = $_POST['artist'];
$tagArray = $_POST['tags'];
$titleArray = $_POST['titles'];
$fileArray = $_FILES['upload']['name'];

//var_dump($fileArray);
/*echo(" ");
var_dump($tagArray);
echo(" ");
//echo($tagArray);
echo $albumName . " " . $artist;*/


//add files to the /songs/ directory

//Loop through each file
for($i=0; $i<count($_FILES['upload']['name']); $i++) {
  //Get the temp file path
  $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

  //Make sure we have a filepath
  if ($tmpFilePath != ""){
    //Setup our new file path
    $newFilePath = "./songs/" . $_FILES['upload']['name'][$i];

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {

      //Handle other code here

    }
  }
}









try {
  //connect to the database
  $db = new PDO('sqlite:database/airport.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
























} catch(PDOException $e) {
    echo 'Exception : '.$e->getMessage();
}


?>
