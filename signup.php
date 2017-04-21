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
     <strong>Sorry!</strong> that email already exists. Please try a different email address.
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

                $message = "
                Thanks for signing up!
                Your account has been created, you can login with the following username and the password provided during account creation.

                ------------------------
                Username: '$uname'
                ------------------------

                Please click this link to activate your account:
                https://sealofhealth.com/verify.php?id=$userID&code=$code

                Seal of Health Development Team";
                $subject = "Confirm Registration";
                $headers = 'From: noreply@sealofhealth.com' . "\r\n";
                mail($email, $subject, $message, $headers);
                $msg = "
                <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Success!</strong> We've sent an email to $email.
                Please click on the confirmation link in the email to create your account.
                </div>
                ";

                if($reg_user->registerPatient($userID))
                {
                    echo "$msg";
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

                $message = "
            Hello,
            Please click on the following link to authenticate $uname ($email) as a Doctor
            https://sealofhealth.com/verify.php?id=$userID&code=$code
            ";
                $subject = "Authentice Doctor Registration";
                $headers = 'From: noreply@sealofhealth.com' . "\r\n";
                mail("sealofhealth@gmail.com",$subject,$message, $headers);
                $msg = "
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Success!</strong> We've sent an email for doctor authentication.
                    Please wait while we authenticate your account.
            </div>
            ";

                if($reg_user->registerDoctor($userID))
                {
                    echo "$msg";
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv-"X-UA-Compatible" content="IE=edge">

    <title>Seal of Health</title>

     <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->       
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

            <!--personalized CSS file by Maria -->
    <link rel="stylesheet" href="main2.css">
    
     <!-- reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
    .container > form > #signinform{
    color: grey;
    font-family:Lucida Sans Unicode;
    }

</style>


</head>
<body id="login">
<div class="container">     
 
    <form action ="" class="form-signin" method="POST">
        
        <div id="signinform">
        <center>
        <form class="form-signin" method="post">
          <img src="Design2.png" width="50%">
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
            <button class="btn btn-lg btn-info" type="submit" name="btn-signup">Sign Up</button>
            </br><br>
            <a id="cc" href="index.php" class="btn btn-large">Already a member? Sign In</a>
            </br></br></br></br></br></br></br></br></br>
        </form>
        <center>
        </div>

    </form>

   
</div> <!-- /container -->

 <center><footer class="container-fluid" id="footer">
    <p><h4>Copyright © Software Seals, 2017.</h4></p>
  </footer></center>
</body>
</html>
