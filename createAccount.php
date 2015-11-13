<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';
require 'PasswordHash.php';

$username = $_SESSION["register/username"];
$email = $_SESSION["register/email"];
$password = $_SESSION["register/password"];

// PHPass is amazing, and will automatically take care of the password salt for us :D
$hasher = new PasswordHash(8, FALSE);
$hash = $hasher->HashPassword($passwordAndSalt);

try {
    $db = new PDO("sqlite:database/noiseFactionDatabase.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $statement = $db->prepare("insert into Account values(?, ?, ?);");
    $result = $statement->execute(array($username, $email, $hash));

    if (!$result) {
        throw new pdoDbException("Something's gone wrong with the prepared statement");
    }
    
    $db = null;
    
} catch(PDOException $e) {
    echo 'Exception: '.$e->getMessage();
}

unset($_SESSION["register/username"]);
unset($_SESSION["register/email"]);
unset($_SESSION["register/password"]);

$_SESSION["username"] = $username;

header("Location: index.php");
exit();
?>
