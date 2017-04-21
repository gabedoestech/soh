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
    $streetAddress = trim($_POST['streetAddress']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zipcode = trim($_POST['zipcode']);
    $app_date = trim($_POST['app_date']);
    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $price = trim($_POST['price']);
    $taken = 0;
    
    if($user_home->createAppointment($userID, $app_name, $streetAddress, $city, $state, $zipcode, $app_date, $start_time, $end_time, $price, $taken))
    {
        $user_home->redirect('doctorhome.php');
    }
    else
    {
        die("fml you failed");
    }
    
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
            <li><a href="doctorhome.php">Home</a></li>

            <!-- Dropdown for appointments -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                    Appointments <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="createapp.php">Create Appointment</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="doctorunscheduled.php">Unscheduled Appointments</a></li>
                    <li><a href="doctorscheduled.php">Scheduled Appointments</a></li>
                    <li><a href="pastapp.php">Past Appointments</a></li>
                </ul>
            </li>
            <!--End Dropdown for appointments -->
            <li><a href="helpdoctor.php">Help</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="log">
            <li><a  style="color:#03CCFE" href="#">Logged in as: <?php echo $row2['userName']; ?></a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div><!-- /.navbar-collapse --></b>
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- OLD NAVBAR -->
<div class="container">

    <ol class="breadcrumb" id="bc1">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading"><b>Create Appointment</b></div>
            <div class="panel-body">
        <form action="" method="POST">
          <div class="form-group row">
            <label for="nameInput" class="col-sm-2 col-sm-form-label">Name:</label>
            <div class="col-sm-4">
              <input class="form-control" type="text" placeholder="Enter the name of the appointment" name="app_name" required>
            </div>
          </div>

          <!-- ADD DATE PICKER LATER TO MAKE ENTRY FANCY -->
          <div class="form-group row">
            <label for="addressInput" class="col-sm-2 col-sm-form-label">Street Address:</label>
            <div class="col-sm-4">
              <input class="form-control" type="text" name="streetAddress" placeholder="Enter the street address of the appointment" id="example-name-input" required>
            </div>
          </div>

            <div class="form-group row">
                <label for="cityInput" class="col-sm-2 col-sm-form-label">City:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" name="city" placeholder="Enter the city" id="example-name-input" required>
                </div>

                <label for="stateInput" class="col-sm-1 col-sm-form-label">State:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" name="state" placeholder="Enter the state" id="example-name-input" required>
                </div>

                <label for="zipcodeInput" class="col-sm-1 col-sm-form-label">Zip:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="text" name="zipcode" placeholder="Enter the zipcode" id="example-name-input" required>
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

            <div align="right"><button class="btn btn-info" type="submit" name='btn-create'><b>Create</b></button></div>
        </form>
      </ol>
    </div>

    </div>


    </div>
    </div>

</body>




</html>