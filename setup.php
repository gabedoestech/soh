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
$connection = new mysqli('localhost', 'root', '0000');
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
createTable('users',
    'userID INT(11) AUTO_INCREMENT',
    'userName VARCHAR(16)',
    'userPass VARCHAR(50) NOT NULL',
    'phone_no INT UNSIGNED NOT NULL',
    'sex VARCHAR(6)',
    'name VARCHAR(20) NOT NULL',
    'address VARCHAR(50)',
    'userEmail VARCHAR(100) NOT NULL',
    'userStatus ENUM(Y,N)',
    'tokenCode VARCHAR(100)',
    'PRIMARY KEY (userID)');
createTable('doctor',
    'userID INT(11)',
    'specialty VARCHAR(20) NOT NULL',
    'PRIMARY KEY (userID)',
    'FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE');
createTable('patient',
    'userID INT(11)',
    'birth_date DATE',
    'ethnicity VARCHAR(15)',
    'PRIMARY KEY (userID)',
    'FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE');
createTable('appointment',
    'appointment_id INT UNSIGNED AUTO_INCREMENT ',
    'userID INT(11) NOT NULL',
    'price REAL NOT NULL',
    'location VARCHAR(50) NOT NULL',
    'app_name VARCHAR(20)',
    'app_date DATE NOT NULL',
    'start_time TIME NOT NULL',
    'end_time TIME NOT NULL',
    'start_pm BOOLEAN',
    'end_pm BOOLEAN',
    'taken BOOLEAN',
    'PRIMARY KEY (appointment_id)',
    'FOREIGN KEY (userID) REFERENCES doctor(userID) ON DELETE CASCADE');
createTable('prescription',
    'drug_name VARCHAR(20)',
    'drug_amount INT UNSIGNED NOT NULL',
    'PRIMARY KEY (drug_name)');
createTable('history',
    'case_id INT UNSIGNED AUTO_INCREMENT',
    'case_name VARCHAR(20)',
    'text VARCHAR(20)',
    'doctor VARCHAR(20) NOT NULL',
    'doc_specialty VARCHAR(20) NOT NULL',
    'date DATE',
    'location VARCHAR(50)',
    'PRIMARY KEY (case_id)',
    'INDEX(case_name(6))');
createTable('uploads',
    'userID INT(11)',
    'case_id INT UNSIGNED',
    'PRIMARY KEY (userID, case_id)',
    'FOREIGN KEY (userID) REFERENCES patient(userID)',
    'FOREIGN KEY (case_id) REFERENCES history(case_id)');
createTable('sees',
    'userID_patient INT(11)',
    'userID_doctor INT(11)',
    'drug_name VARCHAR(20)',
    'appointment_id INT UNSIGNED',
    'PRIMARY KEY (userID_patient, userID_doctor, drug_name, appointment_id)',
    'FOREIGN KEY (userID_patient) REFERENCES patient(userID)',
    'FOREIGN KEY (userID_doctor) REFERENCES doctor(userID)',
    'FOREIGN KEY (drug_name) REFERENCES prescription(drug_name)',
    'FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id)');
echo "<h4>Tables created successfully.<h4>";
?>

<br>
</body>
</html>