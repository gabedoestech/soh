<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();
if($user_login->is_logged_in()!="")
{
    $user_login->redirect('home.php');
}
if(isset($_POST['btn-login']))
{
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtupass']);
    if($user_login->login($email,$upass))
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
<div class="container">
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
    <form class="form-signin" method="post">
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
        <center>
            </br></br></br></br></br>
            <h2 class="form-signin-heading">Sign In</h2><br><br>
            <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
            <br><br>
            <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
            <br><br>
            <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>
            <a href="signup.php" class="btn btn-large">Sign Up</a>
            <br>
            <a href="fpass.php">Lost your Password? </a>
    </form>
    </center>

</div> <!-- /container -->
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>