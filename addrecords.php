<?php
session_start();
require_once 'class.user.php';
require_once 'functions.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}
if ($user_home->is_doctor())
    $user_home->redirect('doctorhome.php');
$userID = $_SESSION['userSession'];
if (isset($_GET['id']) && !empty($_GET['id']))
{
    $id = $_GET['id'];
}
else
    $user_home->redirect('index.php');
if ($userID != $id)
    $user_home->redirect('index.php');
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$query = queryMysql("SELECT * FROM users WHERE userID = '$id' ");
$row2 = $query->fetch_array();
$query2 = queryMysql("SELECT * FROM patient WHERE userID = '$id' ");
$row3 = $query2->fetch_array();
$result = queryMysql("SELECT V.* FROM vitals V, patient P WHERE V.vitalsId = '$id'");
if ($result->num_rows)
{
    $result      = $result->fetch_array();
    $temperature = $result['temperature'];
    $heart_rate  = $result['heartrate'];
    $bp          = $result['bloodpressure'];
    $height      = $result['height'];
    $weight      = $result['weight'];
    $bmi         = $result['BMI'];
    $vitalID     = $result['vitalsId'];
}
?>

<!doctype html>
<html>


<head>
    <title>Edit Profile Information</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main2.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>

    <!-- Styles nav bar -->
    <style>
        .navbar-default {
            background-color: #ffffff;
            border-color: #fefefe;
        }
        .navbar-default .navbar-brand {
            color: #03ccfe;
        }
        .navbar-default .navbar-brand:hover,
        .navbar-default .navbar-brand:focus {
            color: #000000;
        }
        .navbar-default .navbar-text {
            color: #03ccfe;
        }
        .navbar-default .navbar-nav > li > a {
            color: #03ccfe;
        }
        .navbar-default .navbar-nav > li > a:hover,
        .navbar-default .navbar-nav > li > a:focus {
            color: #000000;
        }
        .navbar-default .navbar-nav > .active > a,
        .navbar-default .navbar-nav > .active > a:hover,
        .navbar-default .navbar-nav > .active > a:focus {
            color: #000000;
            background-color: #fefefe;
        }
        .navbar-default .navbar-nav > .open > a,
        .navbar-default .navbar-nav > .open > a:hover,
        .navbar-default .navbar-nav > .open > a:focus {
            color: #000000;
            background-color: #fefefe;
        }
        .navbar-default .navbar-toggle {
            border-color: #fefefe;
        }
        .navbar-default .navbar-toggle:hover,
        .navbar-default .navbar-toggle:focus {
            background-color: #fefefe;
        }
        .navbar-default .navbar-toggle .icon-bar {
            background-color: #03ccfe;
        }
        .navbar-default .navbar-collapse,
        .navbar-default .navbar-form {
            border-color: #03ccfe;
        }
        .navbar-default .navbar-link {
            color: #03ccfe;
        }
        .navbar-default .navbar-link:hover {
            color: #000000;
        }
        @media (max-width: 767px) {
            .navbar-default .navbar-nav .open .dropdown-menu > li > a {
                color: #03ccfe;
            }
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                color: #000000;
            }
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
                color: #000000;
                background-color: #fefefe;
            }
        }
    </style>

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
                    <li class="active"><a href="medicalrecords.php">Medical Records<span class="sr-only">(current)</span></a></li>
                    <li><a href="searchapp_styleupdated.php">Appointments</a></li>
                    <li><a href="help.php">Help</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right" id="log">
                    <li>Logged in as: <?php echo $row2['userName']; ?></li>
                </ul>
        </div><!-- /.navbar-collapse --></b>
    </div> <!-- /.container-fluid -->
</nav>

<!-- OLD NAVBAR -->
<div class="container">

    <?php
    $success = 0;
    if (isset($_POST['temperature']) && !empty($_POST['temperature']))
    {
        $temperature = $_POST['temperature'];
        $success     = 1;
    }
    if (isset($_POST['heartrate']) && !empty($_POST['heartrate']))
    {
        $heart_rate = $_POST['heartrate'];
        $success    = 1;
    }
    if (isset($_POST['bp']) && !empty($_POST['bp']))
    {
        $bp      = $_POST['bp'];
        $success = 1;
    }
    if (isset($_POST['height']) && !empty($_POST['height']))
    {
        $height  = $_POST['height'];
        $success = 1;
    }
    if (isset($_POST['weight']) && !empty($_POST['weight']))
    {
        $weight  = $_POST['weight'];
        $success = 1;
    }
    if (isset($_POST['BMI']) && !empty($_POST['BMI']))
    {
        $bmi     = $_POST['BMI'];
        $success = 1;
    }
    queryMysql("UPDATE vitals set temperature = '$temperature', heartrate = '$heart_rate',
                        bloodpressure = '$bp', height = '$height', weight = '$weight',
                        BMI = '$bmi' WHERE vitalsId = '$vitalID'");
    if ($success)
    {
        ?>

        <div class="alert alert-success" role="alert">
            <strong>Well done!</strong> Your vitals have been updated.
        </div>

    <?php }?>

    <ol class="breadcrumb" id="bc1">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading"><b>Edit Medical Records</b></div>
            <div class="panel-body">
                <form action="" method="POST">

                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Vitals</b></div>
                        <div class="panel-body">
                            <?php echo "<form id='master' action='medicalhistoryfillin.php?id=$id' method='POST'>"; ?>

                            <!-- Form 1 - Vitals -->

                            <div class="form-group row">
                                <label for="tempInput" class="col-sm-2 col-sm-form-label">Temperature (F):</label>
                                <div class="col-sm-4">
                                    <?php echo "<input class='form-control' type='number' placeholder='$temperature' name='temperature' required>";?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hrInput" class="col-sm-2 col-sm-form-label">Heart Rate:</label>
                                <div class="col-sm-4">
                                    <?php echo "<input class='form-control' type='number' placeholder='$heart_rate' name='heartrate' required>";?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="heightInput" class="col-sm-2 col-sm-form-label">Height (in inches):</label>
                                <div class="col-sm-4">
                                    <?php echo "<input class='form-control' type='number' placeholder='$height' name='height' required>";?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="weightInput" class="col-sm-2 col-sm-form-label">Weight (in lbs):</label>
                                <div class="col-sm-4">
                                    <?php echo "<input class='form-control' type='number' placeholder='$weight' name='weight' required>";?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bmiInput" class="col-sm-2 col-sm-form-label">BMI:</label>
                                <div class="col-sm-4">
                                    <?php echo "<input class='form-control' type='number' placeholder='$bmi' name='BMI' required>";?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bpsInput" class="col-sm-2 col-sm-form-label">Blood pressue:</label>
                                <div class="col-sm-4">
                                    <?php echo "<input class='form-control' pattern='[1-9]{3}[/][1-9]{3}' placeholder='$bp' name='bp' required>";?>
                                </div>
                            </div>

                            <div align="right"><button class="btn btn-medium btn-info" type="submit" name='btn-save'><b>Save</b></button></div>
                </form></form>

            </div>
        </div>

        <br>

        <center><footer class="container-fluid" id="footer">
                <p><h4>Copyright © Software Seals, 2017.</h4></p>
            </footer></center>




</body>




</html>