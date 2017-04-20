<?php
session_start();
require_once 'class.user.php';
$reg_user = new USER();
if($reg_user->is_logged_in()!="")
{
    $reg_user->redirect('home.php');
}
if(isset($_POST['btn-signup']))
{
    $uname = trim($_POST['txtuname']);
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtpass']);
    $userType = trim($_POST['userType']);
    $code = md5(uniqid(rand()));
    $stmt = $reg_user->runQuery("SELECT * FROM users WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userID;

    if($stmt->rowCount() > 0)
    {
        $msg = "
        <div class='alert alert-danger'>
     <strong>Sorry!</strong> that email allready exists. Please try a different email address.
     </div>
     ";
    }
    else
    {
        if ($userType == "patient")
        {
            if ($reg_user->register($uname, $email, $upass, $code))
            {
                $stmt = $reg_user->runQuery("SELECT MAX(userID) FROM users");
                $stmt->execute();
                $userID = $stmt->fetchColumn();

                $id = $reg_user->lasdID();
                $key = base64_encode($id);
                $id = $key;
                $message = "
                Hello $uname,
                <br /><br />
                Welcome to Seal of Health!<br/>
                To complete your registration, please click on the following link
                <br /><br />
                <a href='https://notdevin.com/verify.php?id=$id&code=$code'>Click HERE to Activate</a>
                <br /><br />
                Thank You,
                <br/>
                Seal of Health Development Team";
                $subject = "Confirm Registration";
                $reg_user->send_mail($email, $message, $subject);
                $msg = "
                <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Success!</strong> We've sent an email to $email.
                Please click on the confirmation link in the email to create your account.
                </div>
                ";

                if($reg_user->registerPatient($userID))
                {
                    echo " yay you did it";
                }
                else
                {
                    die("fml you failed");
                }
            }
            else
            {
                echo "sorry, something went wrong.. Please try again";
            }
        }
        else if ($userType == "doctor")
        {
            if($reg_user->register($uname,$email,$upass,$code))
            {
                $stmt = $reg_user->runQuery("SELECT MAX(userID) FROM users");
                $stmt->execute();
                $userID = $stmt->fetchColumn();

                $id = $reg_user->lasdID();
                $key = base64_encode($id);
                $id = $key;
                $message = "
            Hello,
            <br /><br />
            Please click on the following link to authenticate $uname ($email) as a doctor
            <br /><br />
            <a href='https://notdevin.com/verify.php?id=$id&code=$code'>Click HERE to Authenticate</a>
            ";
                $subject = "Authentice Doctor Registration";
                $reg_user->send_mail("sealofhealth@gmail.com",$message,$subject);
                $msg = "
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Success!</strong> We've sent an email for doctor authentication.
                    Please wait while we authenticate your account.
            </div>
            ";

                if($reg_user->registerDoctor($userID))
                {
                    echo " yay you did it";
                }
                else
                {
                    die("fml you failed");
                }
            }
            else
            {
                echo "sorry, something went wrong.. Please try again";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta http-equiv-"X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head;
        any other head content must come *after* these tags -->
        
        <!--personalized CSS file by Maria -->        
        <title>Seal of Health</title>
       
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!--Need the above to run dropdown menu -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body id="login">
<div class="container">   
<div class="container">
    <center>

        </br></br></br></br></br>
        <?php if(isset($msg)) echo $msg;  ?>
        <form class="form-signin" method="post">
            <h2 class="form-signin-heading">Sign Up</h2><br>
            <input type="text" class="input-block-level" placeholder="Username" name="txtuname" required />
            <br><br>
            <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
            <br><br>
            <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
            <br><br>
            <select name="userType" class ="input-block-level">
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
            </select>
            <br><br>
            <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
            <br>
            <br>
            <a href="index.php" >Sign In</a>        
        </form>
    </center>

</div> <!-- /container -->
</body>
</html>