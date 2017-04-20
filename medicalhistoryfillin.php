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

            <ol class="breadcrumb" id="bc1">
                <br>
            
            <div class="panel panel-default">
            <div class="panel-heading"><b>Edit Medical Records</b></div>
            <div class="panel-body">
            <form action="" method="POST">

            <div class="panel panel-default">
            <div class="panel-heading"><b>Vitals</b></div>
            <div class="panel-body">
            <form action="" method="POST">

        <!-- Form 1 - Vitals -->

        <div class="form-group row">
            <label for="tempInput" class="col-sm-2 col-sm-form-label">Temperature:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" placeholder="Enter body temperature." name="temperature" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="hrInput" class="col-sm-2 col-sm-form-label">Heart Rate:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter heart rate." name="heartrate" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="heightInput" class="col-sm-2 col-sm-form-label">Height:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter height." name="height" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="weightInput" class="col-sm-2 col-sm-form-label">Weight:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter weight." name="weight" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="bmiInput" class="col-sm-2 col-sm-form-label">BMI:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter BMI." name="BMI" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="respiratoryRateInput" class="col-sm-2 col-sm-form-label">Respiratory Rate:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter a respiratory rate." name="respiratoryrate" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="oximetryInput" class="col-sm-2 col-sm-form-label">Oximetry:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter oximetry." name="oximetry" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="bpsInput" class="col-sm-2 col-sm-form-label">Blood pressue systolic:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter blood pressure systolic." name="bps" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="bpdInput" class="col-sm-2 col-sm-form-label">Blood pressue diastolic:</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" placeholder="Enter blood pressure diastolic." name="bpd" required>
            </div>
        </div>

        <div align="right"><button class="btn btn-medium btn-info" type="submit" name='btn-save'><b>Save</b></button></div>
        </form></form>
                
        </div>
        </div>


        <!-- Form 2 - Medications-->

        <div class="panel panel-default">
            <div class="panel-heading"><b>Medications</b></div>
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
                <th>Status</th>
            </tr>
            <tr>
                <td><input class="form-control" type="text" placeholder="" name="medication" required /></td>
                <td><input class="form-control" type="text" placeholder="" name="instructions" required /></td>
                <td><input class="form-control" type="text" placeholder="" name="dosage" required /></td>
                <td><input class="form-control" type="text" placeholder="" name="start date" required /></td>
                <td><input class="form-control" type="text" placeholder="" name="end date" required /></td>
                <td><input class="form-control" type="text" placeholder="" name="duration" required /></td>
                <td><input class="form-control" type="text" placeholder="" name="status" required /></td>
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

         <!-- Form 3 - Medications-->
        <div class="panel panel-default">
            <div class="panel-heading"><b>Appointment Summaries</b></div>
            <div class="panel-body">
            <form action="" method="POST">
        
        <div class="form-group row">
            <label for="dateSInput" class="col-sm-1 col-sm-form-label">Date:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" placeholder="" name="dateSummary" required>
            </div>
        </div>

        <div class="form-group">
            <label for="comment">Summary:</label>
            <textarea class="form-control" rows="5" id="comment"></textarea>
        </div>
        
        <div align="right"><button class="btn btn-medium btn-info" type="submit" name='btn-save'><b>Save</b></button></div>
        </form></form>
                
        </div>
        </div>

        
        </div>
        </div>
        
         <br>
        
    </ol>

    <br> 
   
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

        '<tr><td><input class="form-control" type="text" placeholder="" name="medication" required' + 
        counter + 
        '"/></td><td><input class="form-control" type="text" placeholder="" name="instructions" required' + 
        counter + 
        '"/></td><td><input class="form-control" type="text" placeholder="" name="dosage" required' +
        counter + 
        '"/></td><td><input class="form-control" type="text" placeholder="" name="start date" required' + 
        counter + 
        '"/></td><td><input class="form-control" type="text" placeholder="" name="end date" required' + 
        counter + 
        '"/></td><td><input class="form-control" type="text" placeholder="" name="duration" required' + 
        counter + 
        '"/></td><td><input class="form-control" type="text" placeholder="" name="status" required' + 
        counter + 
        '"/></td></tr>'
        );
    jQuery('table.table').append(newRow);
});

</script>

 <center><footer class="container-fluid" id="footer">
    <p><h4>Copyright © Software Seals, 2017.</h4></p>
  </footer></center>


  

</body>




</html>