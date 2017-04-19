<?php

	require_once 'functions.php';

	//change location with city when er/db is updated

	function doSearch($city, $doctor, $app_name, $priceLow, $priceHigh, $specialty, $date, $sex, $sort_date)
	{

		if ($sort_date == "date")	$sort = "app_date";
		else $sort = "price";

		if ($doctor == "" && $specialty == "" && $sex == "")
			$stmt = queryMysql("SELECT * FROM Appointment WHERE location = '$city' ORDER BY $sort");
		elseif ($doctor == "" && $sex == "")
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
													 WHERE D.specialty = '$specialty' AND A.location = '$city' ORDER BY $sort");
		}
		elseif ($doctor == "" && $specialty == "")
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
														 WHERE D.sex = '$sex' AND A.location = '$city' ORDER BY $sort");
		}
		elseif ($specialty == "" && $sex == "")
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
													 WHERE D.doctor = '$doctor' AND A.location = '$city' ORDER BY $sort");
		}
		elseif ($specialty == "")
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
													 WHERE D.doctor = '$doctor' AND D.sex = '$sex' AND A.location = '$city' ORDER BY $sort");
		}
		elseif ($sex == "")
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
													 WHERE D.doctor = '$doctor' AND A.location = '$city' AND D.specialty = '$specialty' ORDER BY $sort");
		}
		elseif ($doctor == "")
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
													 WHERE D.specialty = '$specialty' AND A.location = '$city' AND D.sex = '$sex' ORDER BY $sort");
		}
		else
		{
			$stmt = queryMysql("SELECT * FROM (Appointment A
													 INNER JOIN Doctor D ON D.username = A.username)
													 WHERE D.specialty = '$specialty' AND A.location = '$city' AND D.sex = '$sex' AND D.doctor = '$doctor' ORDER BY $sort");
		}

		$appointments = array();

		while ($row = $stmt->fetch_array(MYSQLI_ASSOC))
		{
			$appointments[] = $row;
		}

		if ($app_name != "")
			$appointments = getByAppName($appointments, $app_name);

		if ($priceLow != "" || $priceHigh != "")
			$appointments = filterByPrice($appointments, $priceLow, $priceHigh);

		//yyyy-mm-dd
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $split) && checkdate($split[2],$split[3],$split[1]))
			$appointments = filterByDate($appointments, $date);

		return $appointments;
	}

	function getByAppName($appointments, $name)
	{
		$filtered_appointments = array();
		foreach ($appointments as $appointment)
		{
			if ($appointment['app_name'] == $name)
				$filtered_appointments[] = $appointment;
		}
		return $filtered_appointments;
	}

	function filterByPrice($appointments, $priceLow, $priceHigh)
	{
		$filtered_appointments = array();
		foreach ($appointments as $appointment)
		{
			if ($appointment['price'] >= $priceLow && $appointment['price'] <= $priceHigh)
				$filtered_appointments[] = $appointment;
		}
		return $filtered_appointments;
	}

	function filterByDate($appointments, $date)
	{
		$filtered_appointments = array();
		foreach ($appointments as $appointment)
		{
			if ($appointment['app_date'] == $date)
				$filtered_appointments[] = $appointment;
		}
		return $filtered_appointments;
	}
