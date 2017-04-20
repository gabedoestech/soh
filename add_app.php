<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}
if (!$user_home->is_doctor())
{
    $user_home->redirect('index.php');
}
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['app_id'])
    && !empty($_GET['app_id']))
{
    $id     = $_GET['id'];
    $app_id = $_GET['app_id'];
}

$userID = $_SESSION['userSession'];
$i = 1;

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

<!-- Form 2 - Medications-->
<div class="container">

    <?php
    $result = $user_home->runQuery("SELECT U.firstName, U.lastName FROM users U, patient P WHERE U.userID = '$id'");
    $result->execute(array($_SESSION['userSession']));
    $result = $result->fetch(PDO::FETCH_ASSOC);

    $p_name = $result['firstName'] ." ". $result['lastName'];

    $result = $user_home->runQuery("SELECT A.*, D.specialty, U.firstName, U.lastName, U.userID, S.userID_patient
                        FROM appointment A, users U, doctor D, sees S
                        WHERE S.userID_patient='$id' AND S.appointment_id='$app_id' AND S.userID_doctor = '$userID'
                        AND A.appointment_id = '$app_id'");
    $result->execute(array($_SESSION['userSession']));
    $row3 = $result->fetch(PDO::FETCH_ASSOC);
    $name       = $row3['firstName'] ." ". $row3['lastName'];
    $specialty  = $row3['specialty'];
    $address    = $row3['streetAddress'] . ", " . $row3['city'] . " " . $row3['state']. " ". $row3['zipcode'];
    $phone_no   = $row3['phone_no'];
    $app_name   = $row3['app_name'];
    $app_date   = $row3['app_date'];
    $start_time = $row3['start_time'];
    $end_time   = $row3['end_time'];
    $price      = $row3['price'];
    $appointment_id     = $row3['appointment_id'];
    $summary    = $row3['summary'];
    $success = 0;
    $i = 0;
    while(++$i)
    {
        if (isset($_POST['drugName'.$i]) && !empty($_POST['drugName'.$i])
            && isset($_POST['instructions'.$i]) && !empty($_POST['instructions'.$i])
            && isset($_POST['dosage'.$i]) && !empty($_POST['dosage'.$i])
            && isset($_POST['startDate'.$i]) && !empty($_POST['startDate'.$i])
            && isset($_POST['endDate'.$i]) && !empty($_POST['endDate'.$i])
            && isset($_POST['duration'.$i]) && !empty($_POST['duration'.$i]))
        {
            $drugName   = $_POST['drugName'.$i];
            $instructions = $_POST['instructions'.$i];
            $dosage       = $_POST['dosage'.$i];
            $startDate   = $_POST['startDate'.$i];
            $endDate     = $_POST['endDate'.$i];
            $duration     = $_POST['duration'.$i];
            $userID_patient = $id;
            $userID_doctor = $userID;
            $user_home->addPrescription($drugName, $instructions, $dosage, $startDate, $endDate, $duration);

            $stmt = $user_home->runQuery("SELECT MAX(drugId) FROM prescription");
            $stmt->execute();
            $drugId = $stmt->fetchColumn();

            $user_home->prescribe($userID_doctor, $userID_patient, $drugId);
            $success = 1;
        }
        else
        {
            break;
        }
    }
    if (isset($_POST['summary']) && !empty($_POST['summary']))
    {
        $summary = $_POST['summary'];
        $user_home->addAppointmentSummary($appointment_id, $summary);
        $success = 1;
    }
    if ($success)
    {
        ?>

        <div class="alert alert-success" role="alert">
            <strong>Well done!</strong> Appointment summary has been added/updated.
        </div>

    <?php } ?>

    <ol class="breadcrumb" id="bc1">
        <br>
        <div class="panel panel-default">
            <?php echo "<div class='panel-heading' id='ph'><b>Add Appointment Summary for $p_name</b></div>";?>
            <div class="panel-body">

                <div class="panel panel-default">
                    <div class="panel-heading"><b>Prescribe Medications</b></div>
                    <div class="panel-body">
                        <form action="" method="POST">

                            <table class="table table-bordered" style="width:100%">
                                <tr>
                                    <th>Medication</th>
                                    <th>Instructions</th>
                                    <th>Dosage</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Duration</th>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="text" placeholder="" name="drugName1" required /></td>
                                    <td><input class="form-control" type="text" placeholder="" name="instructions1" required /></td>
                                    <td><input class="form-control" type="text" placeholder="" name="dosage1" required /></td>
                                    <td><input class="form-control" type="date" placeholder="" name="startDate1" required /></td>
                                    <td><input class="form-control" type="date" placeholder="" name="endDate1" required /></td>
                                    <td><input class="form-control" type="text" placeholder="" name="duration1" required /></td>
                                </tr>
                            </table>

                            <div>
                                <a href="#" title="" id="personal" class="add-author"><span class="glyphicon glyphicon-plus"></span> Add New Medication</a>
                            </div>

                            <!-- Remove feature is currently not working :( -->
                            <div>
                                <a href="#" title="" id="personal" class="remove-author"><span class="glyphicon glyphicon-minus"></span> Remove Medication</a>
                            </div>


                            <div align="right"><button class="btn btn-medium btn-info" type="submit" name='btn-save'><b>Save</b></button></div>
                        </form></form>

                    </div>
                </div>

                <!-- Form 3 - Appointment-->
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Appointment Summary</b></div>
                    <div class="panel-body">
                        <form action="" method="POST">
                            <table class="table table-bordered">
                                <h4><b><?php echo $app_name;?></b></h4>
                            <table id='$id' class='table table-bordered'>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Specialty</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                </tr>
                                <tr>
                                    <td><?php echo $name;?></td>
                                    <td><?php echo $specialty;?></td>
                                    <td><?php echo $address;?></td>
                                    <td><?php echo $app_date;?></td>
                                </tr>
                            </table>

                            <br>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Price</th>
                                </tr>
                                <tr>
                                    <td><?php echo $start_time;?></td>
                                    <td><?php echo $end_time;?></td>
                                    <td><?php echo $price;?></td>
                                </tr>
                            </table>
                            </table>

                            <div class="form-group">
                                <label for="comment">Summary:</label>
                                <?php echo "<textarea class='form-control' rows='5' id='comment' name='summary'>$summary</textarea>";?>
                            </div>

                            <div align="right"><button class="btn btn-medium btn-info" type="submit" name='btn-save'><b>Save</b></button></div>
                        </form></form>

                    </div>
                </div>

                <!-- Add more medications-->
                <script type="text/javascript">
                    var counter = 1;
                    jQuery('a.add-author').click(function(event){
                        event.preventDefault();
                        counter++;
                        var newRow = jQuery(
                            //'<tr><td><input type="text" name="first_name' +
                            //counter + '"/></td><td><input type="text" name="last_name' +
                            //counter + '"/></td></tr>'
                            '<tr><td><input class="form-control" type="text" placeholder="" name="drugName'+counter+'" required' +
                            counter +
                            '"/></td><td><input class="form-control" type="text" placeholder="" name="instructions'+counter+'" required' +
                            counter +
                            '"/></td><td><input class="form-control" type="text" placeholder="" name="dosage'+counter+'" required' +
                            counter +
                            '"/></td><td><input class="form-control" type="date" placeholder="" name="startDate'+counter+'" required' +
                            counter +
                            '"/></td><td><input class="form-control" type="date" placeholder="" name="endDate'+counter+'" required' +
                            counter +
                            '"/></td><td><input class="form-control" type="text" placeholder="" name="duration'+counter+'" required' +
                            counter +
                            '"/></td></tr>'
                        );
                        jQuery('table.table').append(newRow);
                    });
                    jQuery('a.remove-author').click(function(event){
                        event.preventDefault();
                        if (counter > 1)
                        {
                            counter--;
                            jQuery('table tr:last-child').remove();
                        }
                    });
                </script>


                <center><footer class="container-fluid" id="footer">
                        <p><h4>Copyright © Software Seals, 2017.</h4></p>
                    </footer></center>



                <!-- Export a Table to PDF - END -->


</body>




</html>