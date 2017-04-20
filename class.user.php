<?php
date_default_timezone_set('Etc/UTC');
require_once 'dbconfig.php';
class USER
{
    private $conn;
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }
    public function register($uname,$email,$upass,$code)
    {
        try
        {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO users(userName,userEmail,userPass,tokenCode)
                                                VALUES(:user_name, :user_mail, :user_pass, :active_code)");
            $stmt->bindparam(":user_name",$uname);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$password);
            $stmt->bindparam(":active_code",$code);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function registerPatient($userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO patient(userID) 
              VALUES (:userID)");
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to register patient into the database.");
            echo $ex->getMessage();
        }
    }

    public function registerDoctor($userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO doctor(userID) 
              VALUES (:userID)");
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert register doctor into the database.");
            echo $ex->getMessage();
        }
    }

    public function updateUser($userID, $firstName, $lastName, $sex, $address, $phone_no)
    {
        try{
            $stmt = $this->conn->prepare("UPDATE users SET firstName=:firstName, lastName=:lastName, sex=:sex, address=:address, phone_no=:phone_no
                                                    WHERE userID=:userID ");
            $stmt->bindparam(":userID",$userID);
            $stmt->bindparam(":firstName",$firstName);
            $stmt->bindparam(":lastName",$lastName);
            $stmt->bindparam(":sex",$sex);
            $stmt->bindparam(":address",$address);
            $stmt->bindparam(":phone_no",$phone_no);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert update user into the database.");
            echo $ex->getMessage();
        }
    }

    public function updatePatient($userID, $birth_date, $ethnicity, $age)
    {
        try{
            $stmt = $this->conn->prepare("UPDATE patient SET birth_date=:birth_date, ethnicity=:ethnicity, age=:age
                                                    WHERE userID=:userID");
            $stmt->bindparam(":userID",$userID);
            $stmt->bindparam(":birth_date",$birth_date);
            $stmt->bindparam(":ethnicity",$ethnicity);
            $stmt->bindparam(":age",$age);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert update patient into the database.");
            echo $ex->getMessage();
        }
    }

    public function updateDoctor($userID, $specialty)
    {
        try{
            $stmt = $this->conn->prepare("UPDATE doctor SET specialty=:specialty WHERE userID=:userID");
            $stmt->bindparam(":userID",$userID);
            $stmt->bindparam(":specialty",$specialty);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert update doctor into the database.");
            echo $ex->getMessage();
        }
    }

    public function createAppointment($userID, $app_name, $streetAddress, $city, $state, $zipcode, $app_date, $start_time, $end_time, $price, $taken)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO appointment(userID,app_name,streetAddress,city,state,zipcode,app_date,start_time,end_time,price,taken)
                                                VALUES(:userID,:app_name,:streetAddress,:city,:state,:zipcode,:app_date,:start_time,:end_time,:price,:taken)");
            $stmt->bindparam(":userID",$userID);
            $stmt->bindparam(":app_name",$app_name);
            $stmt->bindparam(":streetAddress",$streetAddress);
            $stmt->bindparam(":city",$city);
            $stmt->bindparam(":state",$state);
            $stmt->bindparam(":zipcode",$zipcode);
            $stmt->bindparam(":app_date",$app_date);
            $stmt->bindparam(":start_time",$start_time);
            $stmt->bindparam(":end_time",$end_time);
            $stmt->bindparam(":price",$price);
            $stmt->bindparam(":taken",$taken);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert create appointment into the database.");
            echo $ex->getMessage();
        }
    }

    public function scheduleAppointment($userID_patient, $userID_doctor, $appointment_id)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO sees(userID_patient,userID_doctor,appointment_id)
                                                VALUES(:userID_patient,:userID_doctor,:appointment_id)");
            $stmt->bindparam(":userID_patient",$userID_patient);
            $stmt->bindparam(":userID_doctor",$userID_doctor);
            $stmt->bindparam(":appointment_id",$appointment_id);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert sees into the database.");
            echo $ex->getMessage();
        }
    }

    public function patientCancelAppointment($userID_patient, $userID_doctor, $appointment_id)
    {
        try{
            $stmt = $this->conn->prepare("DELETE FROM sees WHERE userID_patient=:userID_patient 
                                                    AND userID_doctor=:userID_doctor AND appointment_id=:appointment_id");
            $stmt->bindparam(":userID_patient",$userID_patient);
            $stmt->bindparam(":userID_doctor",$userID_doctor);
            $stmt->bindparam(":appointment_id",$appointment_id);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert update to appointment into the database.");
            echo $ex->getMessage();
        }
    }

    public function deleteAppointment($appointment_id)
    {
        try{
            $stmt = $this->conn->prepare("DELETE FROM appointment WHERE appointment_id=:appointment_id");
            $stmt->bindparam(":appointment_id",$appointment_id);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert update to appointment into the database.");
            echo $ex->getMessage();
        }
    }

    public function takenAppointment($appointment_id, $taken)
    {
        try{
            $stmt = $this->conn->prepare("UPDATE appointment SET taken=:taken WHERE appointment_id=:appointment_id");
            $stmt->bindparam(":appointment_id",$appointment_id);
            $stmt->bindparam(":taken",$taken);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert update to appointment into the database.");
            echo $ex->getMessage();
        }
    }

    public function login($email,$upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() == 1)
            {
                if($userRow['userStatus']=="Y")
                {
                    if($userRow['userPass']==md5($upass))
                    {
                        $_SESSION['userSession'] = $userRow['userID'];
                        return true;
                    }
                    else
                    {
                        header("Location: index.php?error");
                        exit;
                    }
                }
                else
                {
                    header("Location: index.php?inactive");
                    exit;
                }
            }
            else
            {
                header("Location: index.php?error");
                exit;
            }
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
    public function is_doctor()
    {
        $adminCheck = $this->conn->prepare("SELECT * FROM doctor WHERE userID = :user_id");
        $adminCheck->execute(array(":user_id"=>$_SESSION['userSession']));
        $row2 = $adminCheck->fetch(PDO::FETCH_ASSOC);

        if($adminCheck->rowCount() > 0)
        {
            return true;
        }

    }
    public function is_logged_in()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }
    public function redirect($url)
    {
        header("Location: $url");
    }
    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }
    function send_mail($email,$message,$subject)
    {
        require 'PHPMailerAutoload.php';
        $mail = new PHPMailer; // fill in your email information here
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = 'mail.google.com';
        $mail->Port       = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth   = true;
        $mail->Username="emailAccount_here@gmail.com";
        $mail->Password="password_here";
        $mail->AddAddress($email);
        $mail->SetFrom('NoReply@Group6.com','Group 6');
        $mail->AddReplyTo('NoReply@Group6.com','Group 6');
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        if (!$mail->send()){
            echo "Mailer Error: " .$mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
}