<?php

  require_once 'functions.php';

  //  queryMysql("INSERT INTO users  VALUES('12', 'toothguy', '5f4dcc3b5aa765d61d8327deb882cf99', '123-123-1234', 'Male', 'First1', 'Last1', '101 street ave, Orlando fl 32234', '1@e.com', 'Y', NULL)");
  //  queryMysql("INSERT INTO users  VALUES('13', 'fingerguy', '5f4dcc3b5aa765d61d8327deb882cf99', '234-234-2345', 'Male', 'First2', 'Last2', '102 street ave, Tampa fl 32123', '2@e.com', 'Y', NULL)");
  //  queryMysql("INSERT INTO users  VALUES('14', 'toelady', '5f4dcc3b5aa765d61d8327deb882cf99', '345-345-3456', 'Female', 'First3', 'Last3', '103 street ave, Oviedo fl 32345', '3@e.com', 'Y', NULL )");
  //  queryMysql("INSERT INTO doctor  VALUES('12', 'Dentistry')");
  //  queryMysql("INSERT INTO doctor  VALUES('13', 'Surgery')");
  //  queryMysql("INSERT INTO doctor  VALUES('14', 'Oncology')");
  //
  // for ($i = 20, $j = 0; $i < 30; $i++, $j = ($j+100)%300)
  // {
  //   $start = 120000 + $j;
  //   $end = 130000 + $j;
  //   $price = 350 + $i;
  //   queryMysql("INSERT INTO appointment VALUES(NULL, '12', '', '$price', '101 street ave', 'Orlando', 'fl', '32725', 'Removing $i teeth', '17-05-$i', '$start', '$end', '0')");
  // }
  //
  // for ($i = 20, $j = 0; $i < 30; $i++, $j = ($j+100)%300)
  // {
  //   $start = 120000 + $j;
  //   $end = 130000 + $j;
  //   $price = 650 + $i;
  //   queryMysql("INSERT INTO appointment VALUES(NULL, '12', '', '$price', '101 street ave', 'Orlando', 'fl', '32725', 'Removing $i teeth', '17-04-$i', '$start', '$end', '0')");
  // }
  //
  // for ($i = 20, $j = 0; $i < 30; $i++, $j = ($j+100)%300)
  // {
  //   $start = 150000 + $j;
  //   $end = 160000 + $j;
  //   $price = 250 + $i;
  //   queryMysql("INSERT INTO appointment VALUES(NULL, '13', '', '$price', '102 street ave', 'Tampa', 'fl', '32725', 'Removing $i fingers', '17-05-$i', '$start', '$end', '0')");
  // }
  //
  // for ($i = 10, $j = 0; $i < 16; $i++, $j = ($j+100)%300)
  // {
  //   $start = 80000 + $j;
  //   $end = 90000 + $j;
  //   $price = 350 + $i;
  //   queryMysql("INSERT INTO appointment VALUES(NULL, '14', '', '$price', '103 street ave', 'Oviedo', 'fl', '32725', 'Removing $i toes', '17-06-$i', '$start', '$end', '0')");
  // }

  for ($i = 300; $i < 4000; $i++)
  {
    // $date = strtotime("+$i day", strtotime("1989-02-28"));
    // $date = date("Y-m-d", $date);
    // $app_id = $i + 2500;
    // queryMysql("INSERT INTO appointment VALUES('$app_id', '12', 'no summary', '$i', '101 street ave', 'Orlando', 'fl', '32725', 'Removing $i teeth', '$date', '120000', '130000', '1')");
    // queryMysql("INSERT INTO sees VALUES('1', '12', '$app_id')");
    queryMysql("DELETE FROM appointment WHERE appointment_id = '$i'");
    queryMysql("DELETE FROM sees WHERE appointment_id = '$i'");
  }
?>
