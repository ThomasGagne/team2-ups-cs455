<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Team2</title>
    <link rel="stylesheet" type="text/css" href="css/basic.css">
 </head>
 <body>

   <div class="content">
     <!-- Just include buttons linking to the login page and the "create account" page -->
     <h3>Log in to an existing account:</h3>
     <form action="login.php" method="get">
      <input type="submit" value="Log In" name="Submit"/>
     </form>

     <h3>Or create a new account:</h3>
     <form action="register.php" method="get">
       <input type="submit" value="Create Account" name="Submit"/>
     </form>

     <?php echo "username: " . $_SESSION["username"]; ?>
     

   </div>

 </body>
</html>
