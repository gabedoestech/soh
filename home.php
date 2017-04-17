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
        <title>Profile Information</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main2.css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

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
        <li><a href="home.php">Home</a></li>
        <li class="active"><a href="#">Profile<span class="sr-only">(current)</span></a></li>
        <li><a href="medicalrecords.php">Medical Records</a></li>
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

             <!-- Title of Profile -->
        <div>
          <div>
            <h2>User Profile</h2>
          </div>
          <div>
            <a href="editprofilepatient.php">Edit Profile</a>
          </div>
        </div>
        <!-- End of Title of Profile -->

            <ol class="breadcrumb" id="bc1">
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Profile Information</b></div>
                    <div class="panel-body">
                        <table class="table table-hover ">
                                <col width="10">
                                <col width="10">
                                <tr>
                                    <th scope="row ">Username:</th>
                                    <td colspan="2">
                                        <?php echo $row2['userName']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row ">Full Legal Name:</th>
                                    <td>
                                        <?php echo $row2['name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row ">Date of Birth:</th>
                                    <td>
                                        <?php echo $row3['birth_date']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row ">Sex:</th>
                                    <td colspan="2 ">
                                        <?php echo $row2['sex']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row ">Ethnicity:</th>
                                    <td colspan="2 ">
                                        <?php echo $row3['ethnicity']; ?>
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
                        </table>
                
                <div align="right"><li><a href="editprofilepatient.php"><button class="button button1"><b>Edit Profile Information</b></button></right></a></li>
                    </div>
                    </div>
                </div>


                <br>
                <nav class="navbar navbar-transparent navbar-absolute">

                    <?php
            while ($row4 = $query3->fetch(PDO::FETCH_ASSOC)) {
                $button1 = "btn-cancel".$i;
                $doctorID = $row4['userID'];
                $appID = $row4['appointment_id'];

                if(isset($_POST[$button1]))
                {
                    if($user_home->patientCancelAppointment($userID, $doctorID, $appID) && $user_home->takenAppointment($appID, 0))
                    {
                        $name = $row4['app_name'];
                        $stime = "".$row4['start_time'];
                        $etime = "".$row4['end_time'];
                        $date = "".$row4['app_date'];
                        $email = "".$row4['userEmail'];
                        /*$message = "
                        Hello,
                        <br /><br />
                        The appointment, $name, scheduled from $stime to $etime on $date has been canceled and is available
                        for selection by others. Please delete the appointment if you would not like others to be able
                        to schedule it.
                        <br /><br />
                        Thank you,
                            Seal of Health Team
                        ";
                        $subject = "Appointment Cancellation - ".$row4['app_name'];
                        $reg_user->send_mail($email,$message,$subject);*/
                        echo " yay you did it";
                        $user_home->redirect('home.php');
                    }
                    else
                    {
                        die("fml you failed");
                    }
                }
                ?>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">
                                        <?php echo $row4['app_name']; ?>
                                    </h4>
                                </div>
                                <div class="card-content table-responsive">

                                    <table class="table">
                                        <thead class="text-primary">
                                            <th>Doctor</th>
                                            <th>Specialty</th>
                                            <th>Location</th>
                                            <th>Contact Phone Number</th>
                                        </thead>
                                        <tbody>
                                            <td>
                                                <?php echo $row4['name'];?>
                                            </td>
                                            <td>
                                                <?php echo $row4['specialty'];?>
                                            </td>
                                            <td>
                                                <?php echo $row4['location'];?>
                                            </td>
                                            <td>
                                                <?php echo $row4['phone_no'];?>
                                            </td>
                                            <br>
                                        </tbody>
                                    </table>

                                    <table class="table">
                                        <thead class="text-primary">
                                            <th>Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Price</th>
                                        </thead>
                                        <tbody>
                                            <td>
                                                <?php echo $row4['app_date'];?>
                                            </td>
                                            <td>
                                                <?php echo $row4['start_time'];?>
                                            </td>
                                            <td>
                                                <?php echo $row4['end_time'];?>
                                            </td>
                                            <td>
                                                <?php echo "$".$row4['price'];?>
                                            </td>
                                            <br>
                                        </tbody>
                                    </table>
                                    <div>
                                        <form action="" method="POST">
                                            <button class="btn btn-medium btn-info" type="submit" name="btn-cancel<?php echo $i; ?>" style="text-align:right" color="blue">Cancel
                                </form>
                            </div><br><br>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>

        </nav>
        
    </ol>

    <br> 
   
</div>


 <center><footer class="container-fluid" id="footer">
    <p><h4>Copyright © Software Seals, 2017.</h4></p>
  </footer></center>


  

</body>




</html>