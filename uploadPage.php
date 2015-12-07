<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'generalFunctions.php';
?>

<!DOCTYPE HTML>
<html>
  <head>
      <?php include("head.html"); ?>
      <title>Upload Your Song(s)</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="css/basic.css">
  </head>
      <body>
        <?php include("header.php"); ?>
        <?php include("noscript.html"); ?>

        <script>
          function newRow(){
            var fileRow = document.getElementById("file-upload-rows");
	  var div = document.createElement("div");
            div.innerHTML = '<br><label> Title: <input type="text" name="titles[]"/></label><label> Tags: <input type="text" name="tags[]" /></label><label><input type="file" name="files[]" /></label>';
	  fileRow.appendChild(div);
          };
          </script>

          <br>

          <form action="uploadTestHandler.php" method="post" id="form1" enctype="multipart/form-data">
            Artist: <input type="text" name="artist">
            <input type="submit"/>

            <br>

            <fieldset id="file-upload-rows" action="uploadTestHandler.php" method="post" form="form1">

              <div class = "file-row">
                <label> Title:
                  <input type="text" name="titles[]"/>
                </label>

                <label> Tags:
                  <input type="text" name="tags[]"/>
                </label>

                <label>
                  <input name="upload[]" type="file" multiple="multiple" />
                </label>

              </div>

          </form>

          <br>


            </fieldset>
            <input onClick="newRow();" type="button" id="add-row" name="add-row" value ="Add song" />
      </body>
</html>
