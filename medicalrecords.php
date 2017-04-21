<?php
session_start();
require_once 'class.user.php';
require_once 'functions.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}
$userID = $_SESSION['userSession'];
if (isset($_GET['id']) && !empty($_GET['id']))
    $id = $_GET['id'];
elseif (!$user_home->is_doctor())
    $id = $userID;
else
    $user_home->redirect('index.php');
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$query = queryMysql("SELECT * FROM users WHERE userID = '$id' ");
$row2 = $query->fetch_array();
$query2 = queryMysql("SELECT * FROM patient WHERE userID = '$id' ");
$row3 = $query2->fetch_array();
if ($user_home->is_doctor())
    $query3 = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM appointment A, users U, doctor D, sees S
                          WHERE U.userID = A.userID AND D.userID = U.userID AND D.userID=S.userID_doctor AND S.userID_patient='$id'
                          AND A.appointment_id=S.appointment_id AND D.specialty = (SELECT D.specialty FROM doctor D WHERE userID = '$userID') ORDER BY A.app_date, A.start_time ASC");
else
    $query3 = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no FROM appointment A, users U, doctor D, sees S
                          WHERE U.userID = A.userID AND D.userID = U.userID AND D.userID=S.userID_doctor AND S.userID_patient='$id'
                          AND A.appointment_id=S.appointment_id ORDER BY A.app_date, A.start_time ASC");
$row4 = $query2->fetch_array();
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
}
$result = queryMysql("SELECT P1.* FROM prescription P1, prescribes P2
                        WHERE P1.drugId=P2.drugId AND P2.userID_patient = '$id'");
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

    <ol class="breadcrumb" id="bc1">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading" id="ph"><b>Medical Records</b></div>
            <div class="panel-body">



                <br>

                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Vitals</b></div>
                    <div class="panel-body">

                        <br>
                        <!-- Table will grow accordingly as data submitted -->
                        <table class="table table-bordered" style="width:100%">
                            <tr>
                                <th>Temperature</th>
                                <?php echo "<td>$temperature degress Fahrenheit</td>";?>
                            </tr>
                            <tr>
                                <th>Heart Rate</th>
                                <?php echo "<td>$heart_rate beats/min</td>";?>
                            </tr>
                            <tr>
                                <th>Height</th>
                                <?php echo "<td>$height in</td>";?>
                            </tr>
                            <tr>
                                <th>Weight</th>
                                <?php echo "<td>$weight lbs</td>";?>
                            </tr>
                            <tr>
                                <th>BMI</th>
                                <?php echo "<td>$bmi kg/m2</td>";?>
                            </tr>

                            <tr>
                                <th>Blood pressure</th>
                                <?php echo "<td>$bp mmHg</td>";?>
                            </tr>

                        </table>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Medications</b></div>
                    <div class="panel-body">
                        <br>

                        <!-- Table will grow accordingly as data submitted -->
                        <table class="table table-bordered" style="width:100%">
                            <tr>
                                <th>Medication</th>
                                <th>Instructions</th>
                                <th>Dosage</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                            </tr>
                            <?php
                            if ($result->num_rows)
                            {
                                while ($rowi = $result->fetch_array())
                                {
                                    $medication   = $rowi['drugName'];
                                    $instructions = $rowi['instructions'];
                                    $dosage       = $rowi['dosage'];
                                    $start_date   = $rowi['startDate'];
                                    $end_date     = $rowi['endDate'];
                                    $duration     = $rowi['duration'];
                                    ?>
                                    <tr>
                                        <td><?php echo $medication?></td>
                                        <td><?php echo $instructions?></td>
                                        <td><?php echo $dosage?></td>
                                        <td><?php echo $start_date?></td>
                                        <td><?php echo $end_date?></td>
                                        <td><?php echo $duration?></td>
                                    </tr>
                                <?php }} ?>
                        </table>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Appointment Summaries</b></div>
                    <div class="panel-body">
                        <br>

                        <!-- Table will grow accordingly as data submitted -->
                        <table class="table table-bordered" style="width:100%">
                            <?php
                            while($row6 = $query3->fetch_array())
                            {
                                $date    = $row6['app_date'];
                                $summary = $row6['summary'];
                                $name    = $row6['firstName'] . " ". $row6['lastName'];
                                ?>
                                <tr>
                                    <th>Date</th>
                                    <th>Doctor</th>
                                    <th>Summary</th>
                                </tr>
                                <tr>
                                    <td><?php echo $date?></td>
                                    <td><?php echo $name?></td>
                                    <td><?php echo $summary?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                </div>

                <!-- Added -->
                <button id="exportButton" class="btn btn-lg clearfix"><span class="fa fa-file-pdf-o"></span>Export to PDF</button>
                <!-- Added -->
                <div align='right'>
                    <?php
                    if(!$user_home->is_doctor())
                    {
                    echo "<li><a href='medicalhistoryfillin.php?id=$id'><button class='btn btn-medium btn-info'><b>Edit Vitals</b></button></right></a></li>";
                    ?>
                </div>
                <?php }?>
            </div>
    </ol>

    <br>
</div>

<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>


<script type="text/javascript">
    // We can stylize pdf later.
    jQuery(function ($) {
        $("#exportButton").click(function () {
            // Parse the HTML table element having an id=exportTable
            var dataSource = shield.DataSource.create(
                {
                    data: "#exportTable",
                    schema: {
                        type: "table",
                        fields: {
                            Date: { type: String },
                            Time: { type: String},
                            Facility: { type: String },
                            Provider: { type: String },
                            Reason: { type: String }
                        }
                    }
                }
            );
            // When parsing is done, export the data to PDF
            dataSource.read().then(function (data) {
                var pdf = new shield.exp.PDFDocument({
                    author: "PrepBootstrap",
                    created: new Date()
                });
                pdf.addPage("a4", "portrait");
                pdf.table(
                    80,
                    80,
                    data,
                    [
                        { field: "Date", title: "Date", width: 80 },
                        { field: "Time", title: "Time", width: 80 },
                        { field: "Facility", title: "Facility", width: 80 },
                        { field: "Provider", title: "Provider", width: 80 },
                        { field: "Reason", title: "Reason", width: 80 }
                    ],
                    {
                        margins: {
                            top: 80,
                            left: 80
                        }
                    }
                );
                pdf.saveAs({
                    fileName: "MedicalHistory"
                });
            });
        });
    });
</script>

<style>
    #exportButton {
        border-radius: 0;
    }
</style>


<center><footer class="container-fluid" id="footer">
        <p><h4>Copyright © Software Seals, 2017.</h4></p>
    </footer></center>



<!-- Export a Table to PDF - END -->


</body>




</html>