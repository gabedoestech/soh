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
?>

<!doctype html>
<html>


<head>
    <title>Profile Information</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main2.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>

<body>

<div class="container">
    <div class="backer">
        <center><img src="SH_T_trimmed.png" class="img-rounded" alt="Cinque Terre" width="304" height="236"></center>
    </div>

    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Profile</a></li>

        <p class="navbar-text">Signed in as Maria Mosquera</p>
    </ul>

    <ol class="breadcrumb">
        <br>
        <li><a href="#">Edit Profile Information</a></li>
        <li><a href="doctorhome.php">View Profile</a></li>
        <br><br>

        <!-- Profile Information: User input -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Username:</label>
            <div class="col-sm-10">
                <p class="form-control-static">mariamosquera
                </p>
                <small id="helpInline" class="text-muted">
                    (If you need to change your username, please contact the administrator)
                </small>
            </div>
        </div>

        <div class="form-group row">
            <label for="nameInput" class="col-sm-2 col-sm-form-label">Full Name:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" value="Enter your full name" id="example-name-input">
            </div>
        </div>

        <!-- ADD DATE PICKER LATER TO MAKE ENTRY FANCY -->
        <div class="form-group row">
            <label for="birthdayInput" class="col-sm-2 col-sm-form-label">Specialty:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" value="Enter your specialty" id="example-name-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="sexInput" class="col-sm-2 col-sm-form-label">Sex:</label>
            <div class="col-sm-4">
                <label class="radio-inline"><input type="radio" name="optradio">Male</label>
                <label class="radio-inline"><input type="radio" name="optradio">Female</label>
            </div>
        </div>

        <div class="form-group row">
            <label for="addressInput" class="col-sm-2 col-sm-form-label">Street Address:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" value="Enter your full address" id="example-name-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="phoneInput" class="col-sm-2 col-sm-form-label">Phone Number:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" value="Enter your phone number" id="example-name-input">
            </div>
        </div>

        <div class="form-group row">
            <label for="emailInput" class="col-sm-2 col-sm-form-label">Email Address:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" value="Enter your email address" id="example-name-input">
            </div>
        </div>

        <button type="button" class="btn btn-info">Save Profile</button>

    </ol>
</div>

</div>


</div>
</div>

</body>


</html>