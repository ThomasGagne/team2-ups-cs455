<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start(); }


require_once '../generalFunctions.php';



//In case pressing submit without a selection calls this page
// if(!isset($_POST["privacy"])){
// 	header("Location: /account/index.php?user='" . $_SESSION["username"] . "'");
// 	exit();
// }

$username = $_SESSION["username"];
$privateBool = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
$privateString = $_POST["privacy"];


switch ($privateString) {
    //CHANGE TO PUBLIC
    case "Public":
        try {
        $db = new PDO("sqlite:database/noiseFactionDatabase.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $statement = $db->prepare("update Account set private = false where username= '$username';");
        $result = $statement->execute();

        $db = null;
    
        } catch(PDOException $e) {
         echo 'Exception: '.$e->getMessage();
        }
        
        header("Location: /account/index.php?user=" . $_SESSION["username"] . "");
        exit();
        break;
        //CHANGE TO PRIVATE
        case "Private":
        $privateBool = true;
        $searchName = $_POST["addSearch"];

         try {
        $db = new PDO("sqlite:database/noiseFactionDatabase.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $statement = $db->prepare("update Account set private = true where username= '$username';");
        $result = $statement->execute();

        $db = null;
    
        } catch(PDOException $e) {
         echo 'Exception: '.$e->getMessage();
        }

        header("Location: /account/index.php?user=" . $_SESSION["username"] . "");
        exit();
        break; 
}
}








 
/*try {
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
}*/
?>
 