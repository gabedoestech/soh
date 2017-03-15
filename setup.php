<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h1><u>Database Setup</u></h1>

<?php

  echo "<h4>Connecting to MySQL..<h4>";

  //Put whatever password you set for root when you installed mysql
  //into <dbpass>. Everything else should be good (I think)
  $connection = new mysqli('localhost', 'root', 'dbpass');
  if ($connection->connect_error) die($connection->connect_error);

  echo "<h4>Connected Successfully.<h4>";

  echo "<h4>Creating Database SealOfHealth..<h4>";

  $result = $connection->query('CREATE DATABASE IF NOT EXISTS SealOfHealth');
  if (!$result) die($connection->error);

  echo "<h4>Database SealOfHealth created successfully.<h4>";

  require_once 'functions.php';

  echo "<h4>Creating tables..<h4>";

  //**Discuss whether or not checks, assertions, triggers are needed
  //**Discuss the correctness of:
  createTable('Doctor',
              'username VARCHAR(16) PRIMARY KEY',
              'password VARCHAR(20) NOT NULL',
              'phone_no INT UNSIGNED NOT NULL',
              'sex VARCHAR(6)',
              'name VARCHAR(20) NOT NULL',
              'address VARCHAR(50)',
              'email VARCHAR(25) NOT NULL',
              'specialty VARCHAR(20) NOT NULL',
              'INDEX(username(6))');

  createTable('Patient',
              'username VARCHAR(16) PRIMARY KEY',
              'password VARCHAR(20) NOT NULL',
              'phone_no INT UNSIGNED NOT NULL',
              'sex VARCHAR(6)',
              'name VARCHAR(20) NOT NULL',
              'address VARCHAR(50)',
              'email VARCHAR(25) NOT NULL',
              'birth_date DATE',
              'ethnicity VARCHAR(15)',
              'INDEX(username(6))');

  createTable('Appointment',
              'appointment_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY',
              'username VARCHAR(16)',
              'price REAL NOT NULL',
              'location VARCHAR(50) NOT NULL',
              'app_name VARCHAR(20)',
              'app_date DATE NOT NULL',
              'start_time INT UNSIGNED NOT NULL',
              'end_time INT UNSIGNED NOT NULL',
              'start_pm BOOLEAN',
              'end_pm BOOLEAN',
              'taken BOOLEAN',
              'FOREIGN KEY (username) REFERENCES Doctor(username) ON DELETE CASCADE',
              'INDEX(price)',
              'INDEX(app_date)',
              'INDEX(location(6))');

  createTable('Prescription',
              'drug_name VARCHAR(20) PRIMARY KEY',
              'drug_amount INT UNSIGNED NOT NULL',
              'INDEX(drug_name(6))');

  createTable('History',
              'case_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY',
              'case_name VARCHAR(20)',
              'text VARCHAR(20)',
              'doctor VARCHAR(20) NOT NULL',
              'doc_specialty VARCHAR(20) NOT NULL',
              'date DATE',
              'location VARCHAR(50)',
              'INDEX(case_name(6))',
              'INDEX(date)',
              'INDEX(location(6))');

  createTable('Uploads',
              'username VARCHAR(16)',
              'case_id INT UNSIGNED AUTO_INCREMENT',
              'FOREIGN KEY (username) REFERENCES Patient(username)',
              'FOREIGN KEY (case_id) REFERENCES History(case_id)',
              'INDEX(username(6))',
              'INDEX(case_id(6))');

  createTable('Sees',
              'username_patient VARCHAR(16)',
              'username_doctor VARCHAR(16)',
              'drug_name VARCHAR(20)',
              'appointment_id INT UNSIGNED AUTO_INCREMENT',
              'FOREIGN KEY (username_patient) REFERENCES Patient(username)',
              'FOREIGN KEY (username_doctor) REFERENCES Doctor(username)',
              'FOREIGN KEY (drug_name) REFERENCES Prescription(drug_name)',
              'FOREIGN KEY (appointment_id) REFERENCES Appointment(appointment_id)',
              'INDEX(username_patient(6))',
              'INDEX(username_doctor(6))',
              'INDEX(appointment_id(6))');

  echo "<h4>Tables created successfully.<h4>";
?>

    <br>
  </body>
</html>
