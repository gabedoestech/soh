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
    $code = md5(uniqid(rand()));
    $stmt = $reg_user->runQuery("SELECT * FROM users WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
        if($reg_user->register($uname,$email,$upass,$code))
        {
            $id = $reg_user->lasdID();
            $key = base64_encode($id);
            $id = $key;
            $message = "
      Hello $uname,
      <br /><br />
      Welcome to the Group 6 Project Page!<br/>
      To complete your registration, please click on the following link
      <br /><br />
      <a href='https://notdevin.com/verify.php?id=$id&code=$code'>Click HERE to Activate</a>
      <br /><br />
      Thank You,
      <br/>
      Group Six";
            $subject = "Confirm Registration";
            $reg_user->send_mail($email,$message,$subject);
            $msg = "
     <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Success!</strong> We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account.
       </div>
     ";
        }
        else
        {
            echo "sorry, something went wrong.. Please try again";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>COP4710 Group 6</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/material-kit.css" rel="stylesheet"/>
</head>
<body id="login">
<nav class="navbar navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><h4>Group 6</h4></a>
        </div>

        <div class="collapse navbar-collapse" id="navigation">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <h3>COP4710</h3>
                </li>
            </ul>
        </div>
    </div>
</nav>
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
            <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
            <a href="index.php" class="btn btn-large">Sign In</a>
            </br></br></br>
        </form>
    </center>

</div> <!-- /container -->
<script src="vendors/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>