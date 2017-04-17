<?php

  require_once 'functions.php';

  // queryMysql("INSERT INTO Doctor (username, password, phone_no, sex, name, address, email, specialty) VALUES('IamDoctor1', 'password', '1231231234', 'Male', 'Safa', '1428 elm st', 'email@email.com', 'Tooth removal')");
  // queryMysql("INSERT INTO Doctor (username, password, phone_no, sex, name, address, email, specialty) VALUES('IamDoctor2', 'password', '1231231235', 'Male', 'Safa', '1429 elm st', 'email2@email.com', 'Finger removal')");
  // queryMysql("INSERT INTO Doctor (username, password, phone_no, sex, name, address, email, specialty) VALUES('IamDoctor3', 'password', '1231231236', 'Male', 'Safa', '1427 elm st', 'email3@email.com', 'Toe removal')");

  for ($i = 10, $j = 0; $i < 20; $i++, $j = ($j+100)%300)
  {
    $start = 1200 + $j;
    $end = 1300 + $j;
    $price = 350 + $i;
    queryMysql("INSERT INTO Appointment VALUES(NULL, 'IamDoctor1', '$price', 'Orlando', 'Removing $i teeth', '17-04-$i', '$start', '$end', '1', '1', '0')");
  }
  for ($i = 10, $j = 0; $i < 15; $i++, $j = ($j+100)%300)
  {
    $start = 1500 + $j;
    $end = 1600 + $j;
    queryMysql("INSERT INTO Appointment VALUES(NULL, 'IamDoctor2', '250', 'Tampa', 'Removing $i fingers', '17-04-$i', '$start', '$end', '1', '1', '0')");
  }

  for ($i = 10, $j = 0; $i < 16; $i++, $j = ($j+100)%300)
  {
    $start = 800 + $j;
    $end = 900 + $j;
    queryMysql("INSERT INTO Appointment VALUES(NULL, 'IamDoctor3', '350.5', 'Oviedo', 'Removing $i toes', '17-04-$i', '$start', '$end', '0', '0', '0')");
  }
?>
