<!DOCTYPE HTML>
<html>
  <head>
    <title>List Airplanes</title>
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

          
               $result = $db->query('SELECT * FROM planes;');

            
              //loop through each tuple in result set
              foreach($result as $tuple)
              {
               echo "$tuple[tail_no] $tuple[make] $tuple[model] $tuple[capacity] $tuple[mph]";
               echo "<form action='deleteAirplane.php' method='post'> <input type='hidden' name='tail_no' value='$tuple[tail_no]'> <input type='submit' value='Delete'> </form>";
               echo "<form action='updateAirplane.php' method='post'> <input type='hidden' name='tail_no' value='$tuple[tail_no]'> <input type='submit' value='Update'> </form>";
               echo "<br>";
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
