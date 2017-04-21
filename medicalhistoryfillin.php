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
$result = queryMysql("SELECT V.* FROM vitals V, updates U WHERE V.vitalsId = U.vitalsId AND U.userID_patient = '$id'");
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

<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta http-equiv-"X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <!-- The above 3 meta tags *must* come first in the head;
    any other head content must come *after* these tags -->

    <!--personalized CSS file by Maria -->
    <link rel="stylesheet" href="main2.css">
    <title>Seal of Health</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--Need the above to run dropdown menu -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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
        @media only screen
        and (min-device-width : 320px)
        and (max-device-width : 568px){
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
<!-- added a class in css - logo-img -->
<div class="mylogo">
    <center><img class="logo-img img-responsive" src="Design2.png" width="inherit"></center>
</div>

<!-- NEW NAVBAR -->
<nav class="navbar navbar-default">
    <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <ul class="nav navbar-nav inside-full-height">
            <li><a href="home.php">Home</a></li>
            <li><a href="medicalrecords.php">Medical Records</a></li>

            <!-- Dropdown for appointments -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                    Appointments <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="searchapp_styleupdated.php">Search Appointments</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="scheduledapp.php">Scheduled Appointments</a></li>
                </ul>
            </li>
            <!--End Dropdown for appointments -->

            <li><a href="help.php">Help</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="log">
            <li><a  style="color:#03CCFE" href="#">Logged in as: <?php echo $row2['userName']; ?></a></li>
            <li><a href="logout.php">Logout</a></li>
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
    $result = queryMysql("SELECT V.* FROM vitals V, updates U WHERE V.vitalsId = U.vitalsId AND U.userID_patient = '$id'");
    if (isset($_POST['btn-save']))
    {
        if ($result->num_rows) {
            queryMysql("UPDATE vitals set temperature = '$temperature', heartrate = '$heart_rate',
                      bloodpressure = '$bp', height = '$height', weight = '$weight',
                      BMI = '$bmi' WHERE vitalsId = '$vitalID'");
        } else {
            $user_home->addVitals($temperature, $heart_rate, $bp, $height, $weight, $bmi);
            $stmt = $user_home->runQuery("SELECT MAX(vitalsId) FROM vitals");
            $stmt->execute();
            $vitalsId = $stmt->fetchColumn();
            $user_home->updates($id, $vitalsId);
        }
    }
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
                                    <?php echo "<input class='form-control' pattern='[0-9]{3}[/][0-9]{2}' placeholder='$bp' name='bp' required>";?>
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