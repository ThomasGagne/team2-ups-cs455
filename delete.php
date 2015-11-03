			<?php
			if (empty($_POST["ssn"]))
			{
			//	$deleteErr = "Somehow, the delete link is broken";
			}
			else
			{
				//Grab value to delete tuple with
				$ssn = $_POST["ssn"];

	
				//open the sqlite database file
				$db = new PDO('sqlite:database/airport.db');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				//Run DELETE FROM using the previous value

				try
					{
						$db->exec("DELETE FROM passengers WHERE ssn = '$ssn'");
						$db = null;
					}
				catch(PDOException $e) 
					{
                 		echo 'Exception: '.$e->getMessage();
             		}

				//Redirect when done
				header("Location: showPassengers.php");
			exit();
			}
			?>
