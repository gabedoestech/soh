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
    <div class='container-fluid'>
    <h5>Sorry...<br> That email allready exists. Please try a different email address.
    </div>
    </div>";
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
      <div class='container-fluid'>
      <h6> Success!<br> We've sent an email to $email.
      Please click on the confirmation link in the email to create your account.</h6>
      </div>
      </div>";
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

  <body id="signup">
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
                  <h3>Registration</h3>
              </div>
    <?php if(isset($msg)) echo $msg;  ?>
            <br>
            <div class="content">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">face</i>
                </span>
                <input type="text" class="form-control" placeholder="Full Name" name="txtuname" required />
              </div>
              <br>

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
            <br>
            <div class="footer text-center">
              <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Get Started!</button>
              <br><br>
              <a href="index.php">Need to sign in? Click here!</a>
              <br><br>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> <!-- /container -->
</div>
<script src="vendors/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
