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

if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $privateString = $_POST["privacy"];

     if ($privateString == "Public") {
          try {
        $db = new PDO("sqlite:../database/noiseFactionDatabase.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $statement = $db->prepare("update Account set private = 'false' where username= ?;");
        $result = $statement->execute(array($username));

        $db = null;
    
        } catch(PDOException $e) {
         echo 'Exception: '.$e->getMessage();
        }
        
        header("Location: /account/index.php?user=" . $_SESSION["username"] . "");
        exit();

     } else {

         try {
        $db = new PDO("sqlite:../database/noiseFactionDatabase.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $statement = $db->prepare("update Account set private = 'true' where username= ?;");
        $result = $statement->execute(array($username));

        $db = null;
    
        } catch(PDOException $e) {
         echo 'Exception: '.$e->getMessage();
        }

        header("Location: /account/index.php?user=" . $_SESSION["username"] . "");
        exit();
}
}

?>
 