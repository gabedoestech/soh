<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}

$userID = $_SESSION['userSession'];
$i = 1;

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$query = $user_home->runQuery("SELECT * FROM users WHERE userID = $userID ");
$query->execute(array($_SESSION['userSession']));
$row2 = $query->fetch(PDO::FETCH_ASSOC);

$query2 = $user_home->runQuery("SELECT A.*, D.specialty, U.firstName, U.lastName, U.phone_no FROM appointment A, users U, doctor D
WHERE A.userID = $userID AND D.userID = $userID AND U.userID = $userID AND A.taken=0
GROUP BY A.appointment_id ORDER BY A.app_date, A.start_time ASC");
$query2->execute(array($_SESSION['userSession']));
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
        </div> <!-- /.container-fluid -->
    </nav>


    <!-- OLD NAVBAR -->
    <div class="container">

        <ol class="breadcrumb" id="bc1">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading" id="ph"><b>Unscheduled Appointments</b></div>
                <div class="panel-body">

                    <!-- Add carousel here for potential appointment candidates -->

                    <br><br>

                    <?php
                    while ($row3 = $query2->fetch(PDO::FETCH_ASSOC))
                    {
                    $button1 = "btn-cancel".$i;
                        $button2 = "btn-edit".$i;
                    $appID = $row3['appointment_id'];

                    if(isset($_POST[$button1]))
                    {
                        if($user_home->deleteAppointment($appID))
                        {
                            echo " yay you did it";
                            $user_home->redirect('doctorunscheduled.php');
                        }
                        else
                        {
                            die("fml you failed");
                        }
                    }

                    if(isset($_POST[$button2]))
                    {

                    }
                    ?>
                        <!-- Table will grow accordingly as data submitted -->

                        <table class="table table-bordered">
                            <h4><b><?php echo $row3['app_name'];?></b></h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Doctor</th>
                                    <th>Specialty</th>
                                    <th>Location</th>
                                    <th>Contact Phone Number</th>
                                </tr>
                                <tr>
                                    <td><?php echo $row3['firstName']." ";?><?php echo $row3['lastName'];?></td>
                                    <td><?php echo $row3['specialty'];?></td>
                                    <td><?php echo $row3['streetAddress'].", ";?><?php echo $row3['city'].", ";?><?php echo $row3['state']." ";?><?php echo $row3['zipcode'];?></td>
                                    <td><?php echo $row3['phone_no'];?></td>
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
                                    <td><?php echo $row3['app_date'];?></td>
                                    <td><?php echo $row3['start_time'];?></td>
                                    <td><?php echo $row3['end_time'];?></td>
                                    <td><?php echo "$".$row3['price'];?></td>
                                </tr>
                            </table>
                        </table>

                        <div align="right">
                            <form action="" method="POST">
                                <button class="btn btn-medium btn-info" type="submit" name="btn-edit<?php echo $i; ?>" style="text-align:right" color="green">Edit</button>
                                <button class="btn btn-medium btn-info" type="submit" name="btn-cancel<?php echo $i; ?>" style="text-align:right" color="blue">Delete</button>
                            </form>
                        </div><br><br>

                        <?php $i++; } ?>
                </div>


            </div>
        </ol>
    </div>




    <center><footer class="container-fluid" id="footer">
            <p><h4>Copyright © Software Seals, 2017.</h4></p>
        </footer></center>



    <!-- Export a Table to PDF - END -->


</body>
</html>