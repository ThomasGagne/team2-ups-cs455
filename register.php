<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'generalFunctions.php';

$usernameErr = $emailErr = $totalFailure = "";
$username = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = clean_input($_POST["username"]);
    $email = clean_input($_POST["email"]);
    
    $fail = false;
    
    if (inputted_properly($username) and inputted_properly($email)) {

        // Check if username is taken in the DB
        // In the future, we should do this differently, since our current setup can be broken
        // due to race conditions of 2 users trying to create the same name at the same time.
        try {
            $db = new PDO("sqlite:database/noiseFactionDatabase.db");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Use prepared statements rather than $db->query()
            // It makes the PDO automatically protect against SQL injection
            $statement = $db->prepare("select * from Account where username = ?");
            $result = $statement->execute(array($username));

            if (!$result) {
                // If result is false, something bad's happened.
                throw new pdoDbException("Something's gone wrong with the prepared statement");
            } else if ($statement->fetch() !== false) {
                $usernameErr = "Sorry, that username is already taken.";
                $fail = true;
            }
            
            $db = null;
            
        } catch(PDOException $e) {
            // For now, print out errors so we catch them early. In professional deployment,
            // this should NEVER be done, since it can leak vital DB information.
            // In the future, we'll need to read the exception and give the user an appropriate message.
            echo 'Exception: '.$e->getMessage();
        }

        // Make sure the username only contains standard characters
        if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $username)) {
            $usernameErr = "Sorry, your username can only contain letters, numbers, and underscores!";
            $fail = true;
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Sorry, but this is an invalid email!";
            $fail = true;
        }

        // If everything worked, then let's create an account!
        if (!$fail) {
            // When we use header, php turns the request into a GET and removes the POST variables
            $_SESSION["register/username"] = $username;
            $_SESSION["register/email"] = $email;
            $_SESSION["register/password"] = $_POST["password1"];
            header("Location: createAccount.php");
            exit();            
        }
        
    }else {
        // Something must be empty
        
        if (!input_properly($username)) {
            $usernameErr = "Sorry, your username can't be empty!";
        }

        if (!input_properly($email)) {
            $emailErr = "Sorry, your email can't be empty!";
        }
        
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Team2</title>
        <link rel="stylesheet" type="text/css" href="css/basic.css">
        <script src="js/registerPasswordsMatch.js"></script>
    </head>
    <body>

        <?php include("header.php"); ?>
        <?php include("noscript.html"); ?>
        
        <div class="content">

            <h3>Create a new account:</h3>
            <form method="post" action="register.php">
                What username do you want people to call you by?
                <br>
                Username: <input type="text" name="username" value="<?php echo $username?>">
                <span class="error"><?php echo $usernameErr; ?></span>
                <br><br>
                
                Don't worry, we promise not to send you an email unless we absolutely have to!
                <br>
                Email: <input type="text" name="email" value="<?php echo $email ?>">
                <span class="error"><?php echo $emailErr; ?></span>
                <br><br>

                The strongest passwords are long, memorable, and hard to guess!
                <br>
                Password: <input id="passwordEntry1" type="password" name="password1" onkeyup="passwordsMatch()">
                <br>
                Verify password: <input id="passwordEntry2" type="password" name="password2" onkeyup="passwordsMatch()">
                <br>
                <span id="passwordStatus"></span>
                <br><br>
                <input type="submit" id="submitButton" disabled = "true" name="submit" value="Create Account">
            </form>
        </div>
        
    </body>
</html>
