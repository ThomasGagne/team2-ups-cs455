
  <?php
     $success = "";
     $error = "";
     try {

                 $db = new PDO('sqlite:database/airport.db');
                 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tailno = $_POST['tail_no'];
    $make = $_POST['make'];
  $model = $_POST['model'];
  $capacity = $_POST['capacity'];
  $mph = $_POST['mph'];
  

  $db->query("update planes set tail_no=$tailno, make='$make', model='$model', capacity=$capacity, mph=$mph where tail_no=$tailno;");

    

                 $db = null;
  // redirect after 5 seconds
  $success = "Database successfully updated!";
  header('Location: airplanes.php');

             } catch(PDOException $e) {
                 echo 'Whoops! Exception: '.$e->getMessage();
             
}
?>
