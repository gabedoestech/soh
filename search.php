<?php
require_once 'functions.php';
//change city with city when er/db is updated
function doSearch($city, $first, $last, $app_name, $priceLow, $priceHigh, $specialty, $date, $sex, $sort)
{
    if ($date == "")
        $curr = date("Y-m-d");
    else
        $curr = date("0000-1-1");
    if ($sort == "date")	$sort = "app_date";
    else $sort = "price";
    if ($first == "" && $sex == "")
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE D.specialty = '$specialty' AND A.city = '$city'
													AND A.taken = '0' AND A.app_date >= '$curr' ORDER BY $sort");
    }
    elseif ($first == "" && $specialty == "")
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE U.sex = '$sex' AND A.city = '$city' AND U.userID = D.userID
													AND A.taken = '0' AND A.app_date >= '$curr' ORDER BY $sort");
    }
    elseif ($specialty == "" && $sex == "")
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE U.firstName = '$first' AND U.lastName = '$last' AND A.city = '$city'
													AND u.userID = D.userID AND A.taken = '0' AND A.app_date >= '$curr' ORDER BY $sort");
    }
    elseif ($specialty == "")
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE U.firstName = '$first' AND U.lastName = '$last' AND U.sex = '$sex' AND A.city = '$city'
													AND U.userID = D.userID AND A.taken = '0' AND A.app_date >= '$curr' ORDER BY $sort");
    }
    elseif ($sex == "")
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE U.firstName = '$firstName' AND U.lastName = '$last' AND A.city = '$city'
													AND D.specialty = '$specialty' AND A.app_date >= '$curr'
													AND U.userID = D.userID AND A.taken = '0' ORDER BY $sort");
    }
    elseif ($first == "")
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE D.specialty = '$specialty' AND A.city = '$city' AND U.sex = '$sex' AND A.app_date >= '$curr'
													AND U.userID = D.userID AND A.taken = '0' ORDER BY $sort");
    }
    else
    {
        $stmt = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM (appointment A
													INNER JOIN doctor D ON D.userID = A.userID), users U
													WHERE D.specialty = '$specialty' AND A.city = '$city' AND U.sex = '$sex'
													AND U.firstName = '$first' AND U.lastName = '$last' AND A.app_date >= '$curr'
													AND U.userID = D.userID AND A.taken = '0' ORDER BY $sort");
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