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
        <div >
        <div class="mylogo">
            <center><img class="logo-img img-responsive" src="Design2.png" width="inherit"></center>
        </div>

        <!-- NEW NAVBAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <b><ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li><a href="home.php">Profile</a></li>
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
                    <div class="panel-heading" id="ph"><b>Appointments</b></div>
                    <div class="panel-body">
                  
                  <!-- Add carousel here for potential appointment candidates -->

                  <br><br>

                    <!-- Table will grow accordingly as data submitted -->
                  <table class="table table-bordered">
                  <tr>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Location</th>
                        <th>Contact Phone Number</th>
                  </tr>
                  <tr>
                        <td><?php echo $row3['name'];?></td>
                        <td><?php echo $row3['specialty'];?></td>
                        <td><?php echo $row3['location'];?></td>
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

                   <div align="right">
                    <form action="" method="POST">
                        <button class="btn btn-medium btn-info" type="submit" name="btn-schedule<?php echo $i; ?>" style="text-align:right" color="blue">Schedule
                    </form>
                    </div><br><br>

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