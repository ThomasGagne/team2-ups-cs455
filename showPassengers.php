<!DOCTYPE HTML>
<html>
  <head>
    <title>List Passengers</title>
    <link rel="stylesheet" type="text/css" href="css/basic.css">
  </head>

  <body>

    <div class="content">
            <!-- The search bar -->
            <form action="showPassengers.php" method="post" value="Search">
            Search: <input type="text" name="term" placeholder="Enter first or last name"/><br />
            <input type="submit" name="submit"/>
            </form>
      <?php
         try
         {
            //open the sqlite database file
            $db = new PDO('sqlite:database/airport.db');
 
            // Set errormode to exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           
            

            //See if anything was searched
            if(isset($_POST['term']))
            {
               $term = $_POST['term'];
               //Search for anything with the term in it, but display only f_name and l_name
               $result = $db->query("SELECT f_name, l_name, ssn from passengers NATURAL JOIN onboard NATURAL JOIN flights WHERE f_name LIKE '".$_POST['term']."%' OR l_name LIKE '".$_POST['term']."%'");
               

              

                 // if(mysqli_num_rows($result) <= 0) {
                  
                 //    echo "That record does not exist.";

                 // }

               
                  //if(isset($tuple['flight_no'])){
                     // foreach($result as $tuple)
                     // {
                        
                     //   echo "<tr><td>".$tuple['flight_no']." <form action='delete.php' method='post'>
                     //         <input type='hidden' name='flight_no' value='$tuple[flight_no]'> <input type='submit' value=Delete'> </form> </td>";

                     //   echo "<td>".$tuple['f_name']." ".$tuple['l_name']."<form action='delete.php' method='post'>
                     //         <input type='hidden' name='fname' value='$tuple[f_name]'> <input type='hidden' name='lname' value='$tuple[l_name]'>
                     //         <input type='submit' value='Delete'> </form></td>";

                     //   echo "</tr>";
                     //  }
                  
                  $variable_name = $_REQUEST['term'];
                  // echo $variable_name;
                  
                       
                       foreach($result as $tuple){
                        
                           echo "$tuple[ssn] $tuple[f_name] $tuple[l_name] <form action='delete.php' method='post'>  <input type='hidden' name='ssn' value='$tuple[ssn]'> <input type='submit' value='Delete'> </form>";
                           // echo "<tr><td>".$tuple['f_name']." ".$tuple['l_name']."<form action='delete.php' method='post'>
                           //   <input type='hidden' name='fname' value='$tuple[f_name]'> <input type='hidden' name='lname' value='$tuple[l_name]'>
                           //   <input type='submit' value='Delete'> </form></td>";
                           // echo "</tr>";
                          

                         }
                  
                
            }
            else{
              //otherwise select all passengers
               $result = $db->query('SELECT * FROM passengers');

            
              //loop through each tuple in result set
              foreach($result as $tuple)
              {
               echo "$tuple[ssn] $tuple[f_name] $tuple[l_name] <form action='delete.php' method='post'> <input type='hidden' name='fname' value='$tuple[f_name]'> <input type='hidden' name='lname' value='$tuple[l_name]'> <input type='hidden name='ssn' value='$tuple[ssn]'> <input type='submit' value='Delete'> </form>";
              }
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