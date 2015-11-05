<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accName = test_input($_POST["accountName"]);
    $password = test_input($_POST["password"]);

    if (correct_credentials($accName, $password)) {
        // Need to go to your account page
        // TODO: Implement this once account pages are a thing.

        
        // TODO: we need to query the database here and get the account name,
        // since the user could have supplied an email
        $_SESSION["username"] = $accName;
        $_SESSION["invalidLogin"] = "Good login :)";
        //        header("Location: " . $_SESSION["account"] . ".php");
        //        header("Location: " . $_SESSION["account"] . ".php");
        header("Location: login2.php");
        exit();
    } else {
        $_SESSION["invalidLogin"] = "Bad login";
        //        header("Location: " . $_SESSION["account"] . ".php");
        header("Location: login.php");
        exit();
    }
   
    
}

function correct_credentials($accountName, $password) {
    // TODO: perform password hashing here and check the result against the DB
    if ($accountName == "bad") {
        return false;
    } else {
        return true;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>