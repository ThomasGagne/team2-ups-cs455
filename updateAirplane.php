<!DOCTYPE HTML>
<html>
<head>
  <title>Input Passenger</title>
  <link rel="stylesheet" type="text/css" href="css/basic.css">
</head>

<body>

  <?php
     try {
                 $db = new PDO('sqlite:database/airport.db');
                 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tailno = $_POST['tail_no'];
                 $result = $db->query("select * from planes where tail_no = $tailno;");
    
    // Works because tailno is primary key, so we only expect 1 tuple
    foreach($result as $tuple){
    $make = $tuple['make'];
    $model = $tuple['model'];
    $capacity = $tuple['capacity'];
    $mph = $tuple['mph'];
    }

                 $db = null;

             } catch(PDOException $e) {
                 echo 'Exception: '.$e->getMessage();
             
}
?>

  <div class="content">
    <h3>Input Passenger Details Below:</h3>

    <form method="post" action="updateAirplaneResult.php">
      Tail Number: <input type="text" name="tail_no" value="<?php echo $tailno;?>">
      <br><br>
      Make: <input type="text" name="make" value="<?php echo $make;?>">
      <br><br>
      Model: <input type="text" name="model" value="<?php echo $model;?>">
      <br><br>
      Capacity: <input type="text" name="capacity" value="<?php echo $capacity;?>">
      <br><br>
      MPH: <input type="text" name="mph" value="<?php echo $mph;?>">
      <br><br>
    <input type="submit" name="submit" value="Update">
    </form>


  </div>

</body>
