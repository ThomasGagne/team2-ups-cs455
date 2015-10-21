<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Team2</title>
    <link rel="stylesheet" type="text/css" href="css/basic.css">
  </head>
  <body>
    
    <?php

       $text = trim($_POST["textarea"]);
       // $oldQuery is reentered into the textarea so the query isn't deleted.
       $oldQuery = $_POST["textarea"];
       $sqlError = $result = $success = "";

       if ($text != ""){
           try {
               $db = new PDO('sqlite:database/airport.db');
               $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               // Return a result if it's a select query.
               // Otherwise, execute it.
               if (strtolower(substr($text, 0, 6)) === "select") {
                   $result = $db->query($text);
                   $success = "Results:";
               } else {
                   $db->exec($text);
                   $success = "Query was successful!";
               }
                   
               $db = null;

           } catch(PDOException $e) {
               $sqlError = $e->getMessage();
           }
       }
    ?>

    <div class="content">
      
      <h3>Input an SQL query below:</h3>
     
      <form method="post" action="query.php">
        <textarea name="textarea" rows="5" cols="30"><?php echo $oldQuery?></textarea>
        <br>
        <input type="submit" />
      </form>
     
      <p class="error"><?php echo $sqlError ?></p>
      <h3><?php echo $success ?></h3>
      <?php
         // If result is non-empty, print out each returned tuple
         if ($result !== ""){
             // Get the array of tuples from $result
             $rowArr = $result->fetchAll();
             
             foreach($rowArr as $tuple){
                 // Something weird's going on here, all values are printed twice without this
                 $counter = 0;
                 $tupleToPrint = "";
                 
                 foreach($tuple as $val){
                     $counter += 1;
                     if ($counter % 2 == 1 and $val != ""){
                         $tupleToPrint .= $val.", ";
                     }
                 }
                 // rtrim() removes the trailing comma
                 echo rtrim($tupleToPrint, ", ")."<br/>";
             }
         }        
      ?>
      
    </div>
    
  </body>
</html>
