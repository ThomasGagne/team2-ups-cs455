<?php
	try {
		//connect to the database
		$db = new PDO('sqlite:database/airport.db');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//Update new data
		
		$table = $_POST[table];
		
		if($table === "passengers") {
			$db->exec("
				UPDATE passengers 
				SET 
					f_name = '$_POST[f_name]',
					m_name = '$_POST[m_name]',
					l_name = '$_POST[l_name]',
				WHERE ssn = '$_POST[ssn]'
			");
			header('Location: \showPassengers.php');
		} else if ($table === "planes") {
			$db->exec("
				UPDATE planes 
				SET 
					make = '$_POST[make]',
					model = '$_POST[model]',
					capacity = '$_POST[capacity]',
					mph = '$_POST[mph]'
				WHERE tail_no = '$_POST[tail_no]'
			");
			header('Location: \showPassengers.php');
		} else if ($table === "flights") {
			$db->exec("
				UPDATE flights 
				SET 
					dep_loc = '$_POST[dep_loc]',
					dep_time = '$_POST[dep_time]',
					arr_loc = '$_POST[arr_loc]',
					arr_time = '$_POST[arr_time]'
				WHERE flight_no = '$_POST[flight_no]'
			");
			header('Location: \showPassengers.php');
		} else if ($table === "onboard") {
			$db->exec("
				UPDATE onboard 
				SET 
					dep_loc = '$_POST[dep_loc]',
					dep_time = '$_POST[dep_time]',
					arr_loc = '_POST[arr_loc]',
					arr_time = '$_POST[arr_time]'
				WHERE ssn = '$_POST[ssn]' AND flight_no = '$_POST[flight_no]'
			");
			header('Location: \showPassengers.php');
		} else {
			echo "Something went wrong";
			header('Location: \showPassengers.php');
		}
		
		
	}



?>