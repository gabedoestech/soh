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
        <title>Help</title>
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
        <li><a href="#">Home</a></li>
        <li><a href="home.php">Profile</a></li>
        <li><a href="medicalrecords.php">Medical Records</a></li>
        <li><a href="searchapp_styleupdated.php">Appointments</a></li>
        <li class="active"><a href="#">Help<span class="sr-only">(current)</span></a></li>
        <li><a href="logout.php">Logout</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="log">
        <li>Logged in as: <?php echo $row2['userName']; ?></li>
        </ul>
      </div><!-- /.navbar-collapse --></b>
      </div> <!-- /.container-fluid -->
        </nav>

        <div class="container">

            <ol class="breadcrumb" id="bc1">
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Frequently Asked Questions</b></div>
                    <div class="panel-body">
                        
                    <b> Do I have to create an account in order to search for doctors? </b><br>
                    <p>In order for users to search for doctors and create appointments, we do require the creation of an account on Seal of Health. By creratin gan account you allow us to streamline the search process and tailor the results to match your needs and requirements so that you, the user, gets the absolute best experience we can provide.</p><hr>

                    <b>Am I, as a patient, able to cancel an appointment after I create one? </b><br><br>
                    <p>Absolutely! Our product aims to help patients connect with doctors whenever is most convientient for you. Should you choose to cancel an appointment, we will make sure the doctor recieves a notification about your cancellation so that that spot may be choosen by another patient if needed.</p><hr>

                    <b>Am I, as a doctor, able to cancel an appointment after a patient creates one?</b><br><br>
                    <p>Our system currently does not allow for doctors to cancel appointments appointments once a patient has scheduled one. If you do need to cancel a previously schedualed appointment is is the doctor's responsiblity to notify the patient. However, we do highly encourage doctors to verify the appointment times and dates they list in order to avoid these situations entirely.</p><hr>

                    <b>I can't remember my password! What should I do?</b><br><br>
                    <p>You can recover your password by clicking on the 'Forgot your password?' link at the bottom of the login page. If you find for any reason that you are unable to log into your account, please contacttc our support team at sealofhealth@gmail.com for further instructions.
                    </p><hr>

                    <b>I didn't recieve an appointment confirmation. Was my appointment still created?</b><br><br>
                    <p>If you did not recieve an appointment confirmation email after schedualing an appointment, you should not assume that the appointment was created. Check your 'Current Appointments' tab in your profile and if you do not see the appointment, try to rescheduale the appointment. If you continue to have issues, please contact our support team at sealofhealth@gmail.com.</p><br>

                    </div>
                </div>


                <br>
            
        
    </ol>

    <br> 
   
</div>


 <center><footer class="container-fluid" id="footer">
    <p><h4>Copyright © Software Seals, 2017.</h4></p>
  </footer></center>


  

</body>




</html>