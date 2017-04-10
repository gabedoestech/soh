<?php
session_start();
require_once 'class.user.php';

// This is call from the class.user.php
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
    $user_login->redirect('home.php');
}
if(isset($_POST['btn-login']))
{  
        // saving user info into PHP variables
          $email = trim($_POST['txtemail']);
          $upass = trim($_POST['txtupass']);

    // reCAPTCHA check
    if(isset($_POST['g-recaptcha-response']))
        $captcha=$_POST['g-recaptcha-response'];

    if(!$captcha){
        $msg = " ";
    }
    else if ($user_login->login($email,$upass))
    {
        $user_login->redirect('home.php');
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

    <title>Seal of Health</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/soh.css" rel="stylesheet"/>
    <link href="assets/css/material-kit.css" rel="stylesheet"/>

     <!-- reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body id="login">
<div class="container">
       <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><h4>Seal of Health</h4></a>
                </div>                
            </div>
        </nav>
        
  
    <form action ="" class="form-signin" method="POST">

      <?php
    if(isset($_GET['inactive']))
    {
        ?>
        <br><br><br><div class='alert alert-danger'>
        <strong>Sorry!</strong> This Account has not yet been activated. Please click on the activation link in your email and try again.
    </div>
        <?php
    }
    ?>
        <?php
        if(isset($_GET['error']))
        {
            ?>
            <br><br><br><br><div class='alert alert-danger'>
            <strong>Invalid Credentials</strong>
        </div>
            <?php
        }
        ?>
        <?php if(isset($msg))
        {
            ?>
            <br><br><br><div class='alert alert-danger'>
            <strong>Sorry!</strong> Please try reCAPTCHA again.
        </div>
            <?php
        }
        ?>
     
        <center>
            </br></br></br></br></br>
            <h2 class="form-signin-heading">Sign In</h2><br><br>
            <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
            <br><br>
            <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
            <br><br>              
             <div class="g-recaptcha" data-sitekey="6LfgShsUAAAAAE7Q65POO5f3emf8KnEB93g7LUs-"></div>                
            <br>
            <button class="btn btn-large btn-inverse" type="submit" name="btn-login">Sign in</button>
            <br>
            <a href="terms.php" >Sign Up</a>
            <br>
            <a href="fpass.php">Lost your Password?</a>
            <br>
            <a href="faq.php">FAQ Page</a>
            </center>
    </form>
    

</div> <!-- /container -->
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>