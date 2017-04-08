<?php

	require_once 'functions.php';
	
	class Search
	{
		//$result returned is a mysqli_result object (set of rows returned by query)
		//each row can then be accessed using something like: $row = $result->fetch_array(MYSQLI_ASSOC);
		//and each field from each row can be accessed using something like: $field = $row['field'];
		public function sortByPrice()
		{
			$result = queryMysql("SELECT * FROM Appointment ORDER BY price");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
		public function sortByEarlierDate($date, $time)
		{
			$result = queryMysql("SELECT * FROM Appointment ORDER BY appDate, startTime");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
		public function getByDoctor($doctor)
		{
			$result = queryMysql("SELECT * FROM ((Lists L INNER JOIN Appointment A ON A.appointmentid = L.appointmentid) 
													 INNER JOIN Doctor D ON D.username = L.username)
													 WHERE D.name = '$doctor'");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
		public function getByAppName($name)
		{
			$result = queryMysql("SELECT * FROM Appointment WHERE appName='$name'");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
	
		public function filterByPrice($priceLow, $priceHigh)
		{
			$result = queryMysql("SELECT * FROM Appointment WHERE price >= '$priceLow' AND price <= '$priceHigh'");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
		public function filterBySpecialty($specialty)
		{
			$result = queryMysql("SELECT * FROM ((Lists L INNER JOIN Appointment A ON A.appointmentid = L.appointmentid) 
													 INNER JOIN Doctor D ON D.username = L.username)
													 WHERE D.specialty = '$specialty'");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
		public function filterByDate($date)
		{
			$result = queryMysql("SELECT * FROM Appointment WHERE appDate = '$appDate'");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
		public function filterBySex($sex)
		{
			$result = queryMysql("SELECT * FROM ((Lists L INNER JOIN Appointment A ON A.appointmentid = L.appointmentid) 
													 INNER JOIN Doctor D ON D.username = L.username)
													 WHERE D.sex = '$sex'");
			if ($result && $result->num_rows)
				return $result;
			else
				return NULL;
		}
		
	}