<?php
session_start();
require_once 'class.user.php';
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

$query3 = $user_home->runQuery("SELECT A.*, D.specialty, U.userEmail, U.name, U.phone_no FROM appointment A, users U, doctor D, sees S 
                                    WHERE U.userID = A.userID AND D.userID = U.userID AND D.userID=S.userID_doctor AND S.userID_patient=$userID
                                    AND A.appointment_id=S.appointment_id GROUP BY A.appointment_id ORDER BY A.app_date, A.start_time ASC");
$query3->execute(array($_SESSION['userSession']));
$row4 = $query2->fetch(PDO::FETCH_ASSOC);
?>

    <!doctype html>
    <html>


    <head>
        <title>Medical Records</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main2.css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        
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
        <li><a href="home.php">Profile</a></li>
        <li class="active"><a href="#">Medical Records<span class="sr-only">(current)</span></a></li>
        <li><a href="searchapp.php">Appointments</a></li>
        <li><a href="help.php">Help</a></li>
        <li><a href="logout.php">Logout</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="log">
        <li>Logged in as: <?php echo $row2['userName']; ?></li>
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
              
               <ul style="list-style-type:disc">
                <li>Problems</li>
                <li>Allergies</li>
                <li>Vitals</li>
                <li>Medications</li>
                <li>Appointment Summaries</li>
                </ul>  

                <br><br>
                    
                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Problems</b></div>
                    <div class="panel-body">
                    <br>
                    
                    <!-- Table will grow accordingly as data submitted -->
                    <table id="exportTable" class="table table-bordered" style="width:100%">
                    <tr>
                        <th>Type</th>
                        <th>Condition</th> 
                        <th>Condition Status</th>
                    </tr>
                    <tr>
                        <td>Assessment</td>
                        <td>Hypercholesterolemia</td>
                        <td>Active</td>
                    </tr>
                    <tr>
                        <td>Problem</td>
                        <td>Lactose intolerance</td>
                        <td>Active</td>
                    </tr>
                    <tr>
                        <td>Assessment</td>
                        <td>Cancer</td>
                        <td>Inactive</td>
                    </tr>
                    </table>
                    
                    </div>
                    </div>

                        
                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Allergies</b></div>
                    <div class="panel-body">
                    <br>
                    
                    <!-- Table will grow accordingly as data submitted -->
                    <table id="exportTable1" class="table table-bordered" style="width:100%">
                    <tr>
                        <th>Substance</th>
                        <th>Reaction</th> 
                        <th>Condition Status</th>
                    </tr>
                    <tr>
                        <td>Pineapple</td>
                        <td>Anaphylaxis</td>
                        <td>Active</td>
                    </tr>
                    </table>
                    
                    </div>
                    </div>

                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Vitals</b></div>
                    <div class="panel-body">
                    <br>
                    
                    <!-- Table will grow accordingly as data submitted -->
                    <table class="table table-bordered" style="width:100%">
                    <tr>
                        <th>Temperature</th>
                        <td>97 degress Fahrenheit</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Heart Rate</th>
                        <td>78 /min</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Height</th>
                        <td>5 ft 0 in</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td>5000 lbs</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>BMI</th>
                        <td>50.32 kg/m2</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Resporatory Rate</th>
                        <td>30 / min</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Oximetry</th>
                        <td>94%</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Blood pressure systolic</th>
                        <td>120 mm Hg</td>
                        <td>04/23/17</td>
                    </tr>
                    <tr>
                        <th>Blood pressure diastolic</th>
                        <td>60 mm Hg</td>
                        <td>04/23/17</td>
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
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>Cholecalciferol</td>
                        <td>Orally five times a week</td>
                        <td>500 mg</td>
                        <td>April 3, 2017</td>
                        <td></td>
                        <td>90 days</td>
                        <td>Active</td>
                    </tr>
                    </table>
                    
                    </div>
                    </div>

                <div class="panel panel-default">
                    <div class="panel-heading" id="ph"><b>Allergies</b></div>
                    <div class="panel-body">
                    <br>
                    
                    <!-- Table will grow accordingly as data submitted -->
                    <table class="table table-bordered" style="width:100%">
                    <tr>
                        <th>Date</th>
                        <th>Summary</th>
                    </tr>
                    <tr>
                       <td>07/11/2016</td>
                       <td>The patient seems to be doing well, however an abnormal
                       tumor was found. Further testing will be required.</td>
                    </tr>
                    </table>
                    
                    </div>
                    </div>

                    	<!-- Added -->
			<button id="exportButton" class="btn btn-lg clearfix"><span class="fa fa-file-pdf-o"></span> Export to PDF</button>
			<!-- Added -->

                    <div align="right"><li><a href="editprofilepatient.php"><button class="button button1"><b>Edit Medical History</b></button></right></a></li>
                    </div>
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