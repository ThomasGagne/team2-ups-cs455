<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start(); }


require "../generalFunctions.php";

//In case pressing submit without a selection calls this page
if(!isset($_POST["privacy"])){
	header("Location: /account/index.php?user='" . $_SESSION["username"] . "'");
	exit();
}

$username = $_SESSION["username"];
$searchName = $_REQUEST["addSearch"];


$privateBool = false;

if($_REQUEST["privacy"] == 'public'){
	header("Location: /account/index.php?user='" . $_SESSION["username"] . "'");
	exit();
}
else{
	$privateBool = false;
}
function privacyFunct($setting){
	function clean_input($data);


}

   if(){
   	header("Location: /account/index.php?user='" . $_SESSION["username"] . "'");
	exit();

   }
<!-- 
try {
    $db = new PDO("sqlite:database/noiseFactionDatabase.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   	$statement = $db->prepare("select username from Account where username = ?");
    $result = $statement->execute(array($username));

    if (!$result) {
        throw new pdoDbException("That user doesn't exist");
    }
    
    $db = null;
    
} catch(PDOException $e) {
    echo 'Exception: '.$e->getMessage();
}
?> -->