<?php
session_start();
require_once 'class.user.php';
require_once 'search.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}
else if($user_home->is_doctor())
{
    $user_home->redirect('doctorhome.php');
}
$userID = $_SESSION['userSession'];
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$query = $user_home->runQuery("SELECT * FROM users WHERE userID = $userID ");
$query->execute(array($_SESSION['userSession']));
$row2 = $query->fetch(PDO::FETCH_ASSOC);
$query2 = $user_home->runQuery("SELECT * FROM patient WHERE userID = $userID ");
$query2->execute(array($_SESSION['userSession']));
$row3 = $query2->fetch(PDO::FETCH_ASSOC);
$patientID = $row3['userID'];
if (isset($_GET['id']) && !empty($_GET['id']))
    $id = $_GET['id'];
else
{
    $user_home->redirect('searchapp_styleupdated.php');
}
$curr = date("Y-m-d");
$result = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no
                        FROM appointment A, doctor D, users U WHERE A.appointment_id = '$id'
                        AND D.userID = A.userID AND U.userID = D.userID");
if (!$result->num_rows)
    $user_home->redirect('searchapp_styleupdated.php');
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

<?php
$row3       = $result->fetch_array();
$app_name   = $row3['app_name'];
$name       = $row3['firstName'] . " " . $row3['lastName'];
$specialty  = $row3['specialty'];
$address    = $row3['location'];
$phone_no   = $row3['phone_no'];
$app_date   = $row3['app_date'];
$start_time = $row3['start_time'];
$end_time   = $row3['end_time'];
$price      = $row3['price'];
$app_id         = $row3['appointment_id'];
if (isset($_POST['confirm']) && !empty($_POST['confirm']))
{
    $result = queryMysql("SELECT S.* FROM appointment A, patient P, sees S WHERE
                              S.appointment_id = '$id' AND S.userID_patient <> '$patientID'
                              AND A.taken = '1'");
    $result2 = queryMysql("SELECT S.* FROM sees S, appointment A WHERE
                              A.appointment_id = '$id' AND S.userID_patient = '$patientID'
                              AND A.userID = S.userID_doctor AND A.taken = '1'");
    $result3 = queryMysql("SELECT A.* FROM appointment A WHERE
                              A.appointment_id = '$id' AND A.app_date <= '$curr'
                              AND A.taken = '0'");
    if ($result->num_rows)
    {
        ?>

        <div class="alert alert-danger" role="alert">
            <strong>OH NO!</strong> This appointment has already been taken!
        </div>

    <?php }
    elseif ($result2->num_rows)
    {
        ?>
        <div class="alert alert-warning" role="alert">
            <strong>Relax!</strong> You are already scheduled for this appointment!
        </div>

        <?php
    }
    elseif ($result3->num_rows)
    {
        ?>
        <div class="alert alert-danger" role="alert">
            <strong>OH NO!</strong> You can no longer schedule this appointment!
        </div>

        <?php
    }
    else
    {
        queryMysql("UPDATE appointment set taken = '1' WHERE appointment_id = '$id'");
        $result = queryMysql("SELECT D.userID FROM doctor D, appointment A WHERE
                                  A.appointment_id = '$id' AND A.userID = D.userID");
        $result   = $result->fetch_array();
        $doctorID = $result['userID'];
        queryMysql("INSERT INTO sees VALUES('$patientID', '$doctorID', '$id')");
        ?>

        <div class="alert alert-success" role="alert">
            <strong>Well done!</strong> You are now scheduled for this appointment.
        </div>

    <?php }} ?>


<div class="panel panel-default">
    <div class="panel-heading" id="ph"><b>Confirm Appointment</b></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <h4><b><?php echo $row3['app_name'];?></b></h4>
        <table id='$id' class='table table-bordered'>
            <tr>
                <th>Doctor</th>
                <th>Specialty</th>
                <th>Location</th>
                <th>Contact Phone Number</th>
            </tr>
            <tr>
                <td><?php echo $name;?></td>
                <td><?php echo $specialty;?></td>
                <td><?php echo $address;?></td>
                <td><?php echo $phone_no;?></td>
            </tr>
        </table>

        <br>

        <table class="table table-bordered">
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Price</th>
            </tr>
            <tr>
                <td><?php echo $app_date;?></td>
                <td><?php echo $start_time;?></td>
                <td><?php echo $end_time;?></td>
                <td><?php echo "$".$price;?></td>
            </tr>
        </table>
        </table>

        <div align="right">
            <?php
            echo "<form action='confirm_app.php?id=$id' method='post'>";
            ?>
            <button class="btn btn-medium btn-info" type="submit" name="confirm" value="confirm" style="text-align:right" color="blue">Confirm Appointment</button>
            </form>
        </div>


    </div>
    </ol>
</div>




<center><footer class="container-fluid" id="footer">
        <p><h4>Copyright © Software Seals, 2017.</h4></p>
    </footer></center>




</body>




</html>