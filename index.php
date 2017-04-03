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
  <div class="section section-full-screen section-signup" style="background-image: url('assets/img/wallpaper.jpeg'); background-size: cover; background-position: top center; min-height: 750px;">
      <nav class="navbar navbar-fixed-top">
      <div class="container">
          <div class="navbar-header">
            <div class="logo-container">
              <div class "brand">
                <h3>COP4710</h3>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li>
                <h4>Group 6</h4>
              </li>
            </ul>
          </div>
      </div>
    </nav> <!-- END TOP HEADER.. -->
    <br><br>
      <div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="card card-signup">
             <form class="form-signin" method="post">
              <div class="header header-primary text-center">
									<h3>Sign In</h3>
              </div>

                    <?php
                    if(isset($_GET['inactive']))
                    {
                     ?>
                          <div class="alert alert-info">
                                <div class="container-fluid">
                                 <h5>Sorry... <br> This Account has not yet been activated. Please click on the activation link in your email and try again.</h5>
                                </div>
                             </div>
                              <?php
                    }
                    ?>
                    <?php
                    if(isset($_GET['error']))
              {
               ?>
               <div class="alert alert-danger">
                     <div class="container-fluid">
                      <h5>Sorry... <br>  Invalid Username and/or Password. Please try again.</h5>
                    </div>
                </div>
                        <?php
              }
              ?>
              <br>
              <div class="content">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="material-icons">email</i>
                  </span>
                  <input type="email" class="form-control" placeholder="Email address" name="txtemail" required />
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                  </span>
                  <input type="password" class="form-control" placeholder="Password" name="txtupass" required />
                </div>
              </div>
              <br><br>
              <div class="footer text-center">
                <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>
                <a href="signup.php" class= "btn btn-large btn-default">Register</a>
                <br><br>
                <a href="fpass.php">Lost your Password?</a>
                <br><br>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- /container -->
    </div>
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
