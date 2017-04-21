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

$query2 = $user_home->runQuery("SELECT * FROM doctor WHERE userID = $userID ");
$query2->execute(array($_SESSION['userSession']));
$row3 = $query2->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <center><img class="logo-img img-responsive" src="Design2.png"></center>
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

            <!--Logged in user-->
            <ul class="nav navbar-nav navbar-right" id="log">
                <li><a  style="color:#03CCFE" href="#">Logged in as: <?php echo $row2['userName']; ?></a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div> <!-- /.container-fluid -->
    </nav> <!-- /.navbar -->


    <!-- OLD NAVBAR -->
    <div class="container">

        <ol class="breadcrumb ">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading"><b>Profile Information</b></div>
                <div class="panel-body">
                    <table class="table table-hover ">
                        <tbody>
                        <tr>
                            <th scope="row ">Username:</th>
                            <td colspan="2 ">
                                <?php echo $row2['userName']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Full Legal Name:</th>
                            <td>
                                <?php echo $row2['firstName']." "; ?>
                                <?php echo $row2['lastName']." "; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Specialty:</th>
                            <td colspan="2 ">
                                <?php echo $row3['specialty']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Sex:</th>
                            <td colspan="2 ">
                                <?php echo $row2['sex']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Address:</th>
                            <td colspan="2 ">
                                <?php echo $row2['address']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Phone Number:</th>
                            <td colspan="2 ">
                                <?php echo $row2['phone_no']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Email Adress:</th>
                            <td colspan="2 ">
                                <?php echo $row2['userEmail']; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div align="right"><li><a href="editprofiledoctor.php"><button class="btn btn-medium btn-info"><b>Edit Profile Information</b></button></right></a></li>
                    </div>
                </div>
            </div>

      </ol>
      <br>
    </div>

    
  </body>


  </html>