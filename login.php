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
     <h3>Log in to an existing account:</h3>

     <form method="post" action="loginToAccount.php">
      Account Name or Email: <input type="text" name="accountName">
      <br><br>
    <!-- OOOoooooohhhh look at that plaintext password, baby! -->
      First Name: <input type="password" name="password">
      <br>
      <span class="error"><?php echo $loginErr;?></span>
      <input type="submit" name="submit" value="Log in">
      <br>
      <span class="error"><?php echo $_SESSION["invalidLogin"]; ?></span>
      <br>
      <?php echo $_SESSION["username"]; ?>
      </form>

   </div>

 </body>
</html>
