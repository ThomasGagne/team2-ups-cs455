<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
require 'generalFunctions.php';

<!DOCTYPE html>
<html>
    <head>
        <?php include("head.html"); ?>
    </head>
    <body>

        <?php include("header.php"); ?>
        <?php include("noscript.html"); ?>
<?php
  $title = $songArr["title"];
    $artist = $songArr["artist"];
    $uploader = $songArr["uploader"];
    $score = $songArr["score"];
?>
    <!-- <form action="searchSongs" method="post">
<input id="searchbox" name="q" type="text" placeholder="What would you like to search?"></input>
</form> -->
<div id="heads">
<table style="width:400px">
<th>News</th>
<th>Comp Sci</th>
<th>Entertainment</th>
<th>School</th>

<tr>
  <td><a href="http://www.w3schools.com/">W3Schools</a></td>		
  <td><a href="http://www.netflix.com/WiHome?is=1">Netflix</a></td>
  <td><a href="https://webmail.pugetsound.edu/">Email</a></td>
  <td><a href="https://webmail.pugetsound.edu/">Email</a></td>
</tr>

<tr>
  <td><a href="http://www.reuters.com/">Reuters</a></td>
  <td><a href="http://codingbat.com/">codingbat</a></td>		
  <td><a href="https://moodle.pugetsound.edu/moodle/login/index.php">Moodle</a></td>
  <td><a href="https://webmail.pugetsound.edu/">Email</a></td>
  </tr>

<tr>
  <td><a href="http://cnn.com">CNN</a></td>
  <td><a href="http://www.codecademy.com/">Code Academy</a></td>		
  <td><a href="https://pugetsound-csm.symplicity.com/students/">Logger jobs</a></td>
  <td><a href="https://webmail.pugetsound.edu/">Email</a></td>
</tr>
</table>
</div>
</body>
</html>