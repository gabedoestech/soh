<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}

$userID = $_SESSION['userSession'];

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$query = $user_home->runQuery("SELECT * FROM users WHERE userID = $userID ");
$query->execute(array($_SESSION['userSession']));
$row2 = $query->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['btn-create']))
{
    $app_name = trim($_POST['app_name']);
    $location = trim($_POST['location']);
    $app_date = trim($_POST['app_date']);
    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $price = trim($_POST['price']);
    $taken = 0;
    
    if($user_home->createAppointment($userID, $app_name, $location, $app_date, $start_time, $end_time, $price, $taken))
    {
        echo " yay you did it";
        $user_home->redirect('doctorhome.php');
    }
    else
    {
        die("fml you failed");
    }
    
}
?>

  <!doctype html>
  <html>


  <head>
    <title>Appointments</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main2.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">


  </head>

  <body>

    <!-- Logo -->
    <div class="mylogo">
      <center><img src="Design2.png" width="608" height="230"></center>
    </div>

    <!-- NEW NAVBAR -->
    <nav class="navbar navbar-default">
      <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <b><ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="doctorhome.php">Profile</a></li>
            <li class="active"><a href="createapp.php">Appointment<span class="sr-only">(current)</span></a></li>
            <li><a href="help.php">Help</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        
<ul class="nav navbar-nav navbar-right" id="log">
<li>Logged in as: <?php echo $row2['userName']; ?></li>
</ul>
</div><!-- /.navbar-collapse --></b>
        </div>
        <!-- /.container-fluid -->
    </nav>

 <!-- OLD NAVBAR -->
    <div class="container">

      <ol class="breadcrumb">
        <br>
        <li><a href="#">Edit Profile Information</a></li>       
        <br>

        <h2>Create Appointment</h2>
        <br>
        <form action="" method="POST">
          <div class="form-group row">
            <label for="nameInput" class="col-sm-2 col-sm-form-label">Name:</label>
            <div class="col-sm-4">
              <input class="form-control" type="text" placeholder="Enter the name of the appointment" name="app_name" required>
            </div>
          </div>

          <!-- ADD DATE PICKER LATER TO MAKE ENTRY FANCY -->
          <div class="form-group row">
            <label for="birthdayInput" class="col-sm-2 col-sm-form-label">Location:</label>
            <div class="col-sm-4">
              <input class="form-control" type="text" name="location" placeholder="Enter the address of the appointment" id="example-name-input" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="birthdayInput" class="col-sm-2 col-sm-form-label">Date:</label>
            <div class="col-sm-4">
              <input class="form-control" type="date" name="app_date" id="example-name-input" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="phoneInput" class="col-sm-2 col-sm-form-label">Start Time:</label>
            <div class="col-sm-4">
              <input class="form-control" type="time" name="start_time" id="example-name-input" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="phoneInput" class="col-sm-2 col-sm-form-label">End Time:</label>
            <div class="col-sm-4">
              <input class="form-control" type="time" name="end_time" id="example-name-input" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="birthdayInput" class="col-sm-2 col-sm-form-label">Price:</label>
            <div class="col-sm-4">
              <input class="form-control" type="text" name="price" placeholder="Enter the price of the appointment (##.##)" id="example-name-input" required>
            </div>
          </div>

          <button class="btn btn-info" type="submit" name='btn-create'>Create</button>
        </form>
      </ol>
    </div>

    </div>


    </div>
    </div>

  </body>


  </html>