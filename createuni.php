<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['btn-createuni']))
{
    $uni_name = trim($_POST['uni_name']);
    $user_id = trim($_POST['ad_id']);
    $uni_loc = trim($_POST['uni_loc']);
    $stu_num = trim($_POST['stu_num']);
    $uni_des = trim($_POST['uni_des']);
    $uni_im = $_POST['uni_image'];

    $check = $user_home->runQuery("SELECT * FROM affiliateduniversityprofile WHERE name=:uni_name");
    $check->execute(array(":uni_name"=>$uni_name));
    $row = $check->fetch(PDO::FETCH_ASSOC);

    $adminCheck = $user_home->runQuery("SELECT * FROM useradminowns WHERE userID=:user_id");
    $adminCheck->execute(array(":user_id"=>$user_id));
    $row2 = $adminCheck->fetch(PDO::FETCH_ASSOC);
    
    if($check->rowCount() > 0)
    {
      $msg = "
        <div class='alert alert-danger'>
     <strong>Sorry!</strong> There's already a profile for that university.
     </div>
     ";
    }
    else if ($adminCheck->rowCount()==0) {
      $msg = "
        <div class='alert alert-danger'>
     <strong>Sorry!</strong> There's no admin with that ID.
     </div>
     ";
    }
    else
    {
      if($user_home->makeUni($uni_name, $user_id, $uni_loc, $stu_num, $uni_des, $uni_im))
      {
        echo " yay you did it";
      }
      else
      {
        die("fml you failed");
      }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8" />
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
        <form class="form-signin" method="post">
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
      <?php if(isset($msg)){ ?>
      <br><br><br><div class='alert alert-danger'><?php echo $msg ?>
   </div>
   <?php } ?>
      </br></br></br></br></br>
        <h2 class="form-signin-heading">Create a University Profile</h2><br><br>
        <input type="text" class="input-block-level" placeholder="Name of University" name="uni_name" required />
        <br><br>
        <input type="text" class="input-block-level" placeholder="Location" name="uni_loc" required />
        <br><br>
        <input type="text" class="input-block-level" placeholder="Admin's ID" name="ad_id" maxlength="11" required />
        <br><br>
        <input type="text" class="input-block-level" placeholder="Description (not required)" name="uni_des" />
        <br><br>
        <input type="text" class="input-block-level" placeholder="Number of Students" name="stu_num"/>
        <br><br>
        <h6>Image for Profile:</h6>
        <input type="file" name="uni_image">
        <br><br>
        <button class="btn btn-large btn-primary" type="submit" name="btn-createuni">Create University</button>
        <br>
      </form>
    </center>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
