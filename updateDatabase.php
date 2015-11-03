<!DOCTYPE HTML>
<html>
	<head>
		<title>
			List Passengers
		</title>
		<link rel="stylesheet" type="text/css" href="css/basic.css">
	</head>
	<body>
		<div class="content">
		
			<!-- example form
			<h2>Update Passengers Values</h2>
			//form for passengers table
			<form  action="addRedirectLater.php" method="post">
				First Name: <input type="text" name="f_name"/><br/>
				Middle Name: <input type="text" name="m_name"/><br/>
				Last Name: <input type="text" name="l_name"/><br/>
				SSN: <input type="text" name="ssn"/><br/>
				
				<input type="submit"/>
			</form> -->
			
			//form for planes table
			
			//form for flights table
			
			//form for onboard table
			
			
		
		
			<?php
				try {
				//connect to the database
				$db = new PDO('sqlite:database/airport.db');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				//get data from passengers table
				$passengersAll = $db->query('SELECT * FROM passengers');
				
				//get data from planes table
				$placesAll = $db->query('SELECT * FROM planes');
				
				//get data from flights table
				$flightsAll = $db->query('SELECT * FROM flights');
				
				//get data from onboard table
				$onboardAll = $db->query('SELECT * FROM onboard');
				
				echo "<h2>Passengers</h2>";
				foreach($passengersAll as $tuple) {
					echo "<br>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</br>";
					echo "<form  action=\"updateFormHandler.php\" method=\"post\">
							First Name: <input type=\"text\" name=\"f_name\" value=\"$tuple[f_name]\" />
							Middle Name: <input type=\"text\" name=\"m_name\" value=\"$tuple[m_name]\"/>
							Last Name: <input type=\"text\" name=\"l_name\" value=\"$tuple[l_name]\"/>
							SSN: <input type=\"text\" name=\"ssn\" value=\"$tuple[ssn]\"/>
				
							<input type=\"hidden\" name=\"table\" value=\"passengers\"/>
							<input type=\"submit\"/>
						</form>";
				}
				
				echo "<h2>planes</h2>";
				foreach($placesAll as $tuple) {
					echo "<br>----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</br>";
					echo "<form  action=\"updateFormHandler.php\" method=\"post\">
							Tail Number: <input type=\"text\" name=\"tail_no\" value=\"$tuple[tail_no]\" />
							Make: <input type=\"text\" name=\"make\" value=\"$tuple[make]\" \>
							Model: <input type=\"text\" name=\"model\" value=\"$tuple[model]\"/>
							Capacity: <input type=\"text\" name=\"capacity\" value=\"$tuple[capacity]\"/>
							Miles Per Hour (MPH): <input type=\"text\" name=\"mph\" value=\"$tuple[mph]\"/>
				
							<input type=\"hidden\" name=\"table\" value=\"planes\"/>
							<input type=\"submit\"/>
						</form>";
				}
				
				echo "<h2>Flights</h2>";
				foreach($flightsAll as $tuple) {
					echo "<br>--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</br>";
					echo "<form  action=\"updateFormHandler.php\" method=\"post\">
							Flight Number: <input type=\"text\" name=\"flight_no\" value=\"$tuple[flight_no]\" />
							Departure Location: <input type=\"text\" name=\"dep_loc\" value=\"$tuple[dep_loc]\"/>
							Departure Time: <input type=\"text\" name=\"dep_time\" value=\"$tuple[dep_time]\"/>
							Arrival Location: <input type=\"text\" name=\"arr_loc\" value=\"$tuple[arr_loc]\"/>
							Arrival Time: <input type=\"text\" name=\"arr_time\" value=\"$tuple[arr_time]\"/>
							Tail Number: <input type=\"text\" name=\"tail_no\" value=\"$tuple[tail_no]\"/>
							
							<input type=\"hidden\" name=\"table\" value=\"flights\"/>
							<input type=\"submit\"/>
						</form>";
				}
				
				echo "<h2>Onboard</h2>";
				foreach($onboardAll as $tuple) {
					echo "<br>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</br>";
					echo "<form  action=\"updateFormHandler.php\" method=\"post\">
							Social Security Number: <input type=\"text\" name=\"ssn\" value=\"$tuple[ssn]\"/>
							Flight Number: <input type=\"text\" name=\"flight_no\" value=\"$tuple[flight_no]\"/>
							Seat: <input type=\"text\" name=\"seat\" value=\"$tuple[seat] ?>\"/>
				
							<input type=\"hidden\" name=\"table\" value=\"onboard\"/>
							<input type=\"submit\"/>
						</form>";
				}
				
				
				
				} catch(PDOException $e) {
					echo 'Exception : '.$e->getMessage();
				}
	
			?>
</div>
	</body>
	</html>