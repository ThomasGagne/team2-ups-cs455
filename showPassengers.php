<!DOCTYPE HTML>
<html>
  <head>
    <title>List Passengers</title>
    <link rel="stylesheet" type="text/css" href="css/basic.css">
  </head>

  <body>

    <div class="content">
      <?php
         try
         {
            //open the sqlite database file
            $db = new PDO('sqlite:database/airport.db');
 
            // Set errormode to exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
            //select all passengers
            $result = $db->query('SELECT * FROM passengers');
 
            //loop through each tuple in result set
            foreach($result as $tuple)
            {
              echo "$tuple[ssn] $tuple[f_name] $tuple[l_name]<br/>";
            }
 
            //disconnect from database
            $db = null;
         }
         catch(PDOException $e)
         {
           echo 'Exception : '.$e->getMessage();
         }
      ?>
    </div>

  </body>

</html>