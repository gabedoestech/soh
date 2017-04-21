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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

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
}</style>


</head>
<body id="login">
<div class="container">     
 
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
        
        <div id="signinform">
        <center>
            </br>
            <img src="Design2.png" width="50%">
            <h2 class="form-signin-heading">Sign In</h2><br>
            <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
            <br><br>
            <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
            <br><br>              
             <div class="g-recaptcha" data-sitekey="6LfgShsUAAAAAE7Q65POO5f3emf8KnEB93g7LUs-"></div>                
            <br>
            <button class="btn btn-lg btn-info" type="submit" name="btn-login">Sign in</button>
            <br><br>
            <a href="terms.php" >Sign up</button></a>
            <br>
            <a href="fpass.php">Forgot your password?</a>
            <br>
            <a href="faq.php">FAQ Page</a>
            </center>
            <br>
        </div>
        <br>
        <br><br>

    </form>

   
</div> <!-- /container -->
 
</body>
</html>