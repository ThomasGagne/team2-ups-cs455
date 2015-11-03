			<?php
			if (empty($_POST["tail_no"]))
			{
			//	$deleteErr = "Somehow, the delete link is broken";
			}
			else
			{
				//Grab value to delete tuple with
				$tailno = $_POST["tail_no"];

				echo "adfe"	;
				//open the sqlite database file
				$db = new PDO('sqlite:database/airport.db');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				//Run DELETE FROM using the previous value

				try
					{
						$db->exec("DELETE FROM planes WHERE tail_no = '$tailno'");
						$db = null;
					}
				catch(PDOException $e) 
					{
                 		echo 'Exception: '.$e->getMessage();
             		}

				//Redirect when done
				echo "done;";
				header("Location: airplanes.php");
			exit();
			}
			?>
