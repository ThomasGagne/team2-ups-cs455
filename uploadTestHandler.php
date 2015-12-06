<?php

$albumName = $_POST['album'];
$artist = $_POST['artist'];
$tagArray = $_POST['tags'];
$titleArray = $_POST['titles'];
$fileArray = $_FILES['upload']['name'];

//Loop through each file
/*if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
  for($i=0; $i<count($_FILES['upload']['name']); $i++) {
    $fileName = $_FILES['upload']['name'][$i];
    echo($fileName);
  };
};*/


//var_dump($fileArray);
echo(" ");
var_dump($tagArray);
echo(" ");
//echo($tagArray);
echo $albumName . " " . $artist;

?>
