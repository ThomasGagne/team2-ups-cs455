<!DOCTYPE HTML>
<html>
<head>
  <title>Input Passenger</title>
  <link rel="stylesheet" type="text/css" href="css/basic.css">
</head>

<body>

  <!-- Behind-the-scenes php -->
  <?php
     $ssn = $fnameErr = $lnameErr = $lnameErr = "";
     $ssn = $fname = $lname = $ssnErr = "";
     $success = "";
     
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if (empty($_POST["ssn"])) {
             $ssnErr = "SSN is a required field";
         } else {
             $ssn = test_input($_POST["ssn"]);
             // Check that SSN is well-formed
             if (!preg_match("(^\d{3}-?\d{2}-?\d{4}$|^XXX-XX-XXXX$)",$ssn)) {
                 $ssnErr = "SSN must be formatted as: XXX-XX-XXXX";
             }
         }
         
         if (empty($_POST["fname"])) {
             $fnameErr = "First name is a required field";
         } else {
             $fname = test_input($_POST["fname"]);
         }
         
         if (empty($_POST["lname"])) {
             $lnameErr = "Last name is a required field";
         } else {
             $lname = test_input($_POST["lname"]);
         }

         // Make INSERT query if all fields are valid
         if (!empty($ssn) and !empty($fname) and !empty($lname)) {
             try { 
                 $db = new PDO('sqlite:database/airport.db');
                 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 
                 $db->exec("insert into passengers values('$fname', null, '$lname', '$ssn');");
                 $success = "Passenger successfully inserted!";
                 
                 $db = null;
                 
             } catch(PDOException $e) {
                 echo 'Exception: '.$e->getMessage();
             }
         }
     }

     function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
     }
  ?>
     
  <div class="content">
    <h3>Input Passenger Details Below:</h3>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      SSN: <input type="text" name="ssn" value="<?php echo $ssn;?>" placeholder="XXX-XX-XXXX" maxlength="11">
      <span class="error"><?php echo $ssnErr;?></span>
      <br><br>
      First Name: <input type="text" name="fname" value="<?php echo $fname;?>">
      <span class="error"><?php echo $fnameErr;?></span>
      <br><br>
      Last Name: <input type="text" name="lname" value="<?php echo $lname;?>">
      <span class="error"><?php echo $lnameErr;?></span>
      <br><br>
      <input type="submit" name="submit" value="Submit">
    </form>

    <h3><?php echo $success;?></h3>

  </div>

</body>
