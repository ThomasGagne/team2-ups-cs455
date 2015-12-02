<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

// Note: all paths are relative to the current page, not the DocumentRoot!
require "../generalFunctions.php";

// If we don't have a GET variable set, just redirect to the homepage.
// Maybe we can have a page which lists currently popular users?
if (!isset($_GET["user"])) {
    header("Location: /index.php");
    exit();
} else {
    $user = $_GET["user"];
    // What should you be able to do on your account page?
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("../head.html"); ?>
    </head>
    <body>

        <?php include("../header.php"); ?>
        <?php include("../noscript.html"); ?>
        
        <div class="content">
            <?php echo "<h3>" . $user . "'s Profile</h3>"; ?>
            Down here's gonna go some amazing stuff.
            For example, let's get their most recently uploaded songs or something, I dunno.
        </div>
        
    </body>
</html>
