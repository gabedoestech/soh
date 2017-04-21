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
    $user_home->redirect('createapp.php');
}

$userID = $_SESSION['userSession'];
$i = 1;

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$query = $user_home->runQuery("SELECT * FROM users WHERE userID = $userID ");
$query->execute(array($_SESSION['userSession']));
$row2 = $query->fetch(PDO::FETCH_ASSOC);

$query2 = $user_home->runQuery("SELECT A.*, D.userID, D.specialty, U.firstName, U.lastName, U.phone_no FROM appointment A, users U, doctor D 
                                    WHERE U.userID = A.userID AND D.userID = U.userID AND A.taken = 0 GROUP BY A.app_name");
$query2->execute(array($_SESSION['userSession']));
?>

<!doctype html>
<html>


<head>
    <title>Appointments</title>
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
        <li><a href="home.php">Profile</a></li>
        <li><a href="medicalrecords.php">Medical Records</a></li>
        <li class="active"><a href="#">Appointments<span class="sr-only">(current)</span></a></li>        
        <li><a href="help.php">Help</a></li>
        <li><a href="logout.php">Logout</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right" id="log">
        <li>Logged in as: <?php echo $row2['userName']; ?></li>
        </ul>
      </div><!-- /.navbar-collapse --></b>
      </div> <!-- /.container-fluid -->
        </nav>


    <div class="container ">

    <ol class="breadcrumb ">
        <br>
        <li><a href="editprofilepatient.php">Edit Profile Information</a></li>
        <li><a href="#">View Profile</a></li>
        <br><br>

        <h2>Search for an Appointment</h2>
        <br>
        <nav class="navbar navbar-transparent navbar-absolute">

            <?php
            while ($row3 = $query2->fetch(PDO::FETCH_ASSOC)) {
                $button1 = "btn-schedule".$i;
                $doctorID = $row3['userID'];
                $appID = $row3['appointment_id'];

                if(isset($_POST[$button1]))
                {
                        if($user_home->scheduleAppointment($userID, $doctorID, $appID) && $user_home->takenAppointment($appID, 1))
                        {
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
                            <h4 class="title"><?php echo $row3['app_name']; ?></h4>
                        </div>
                        <div class="card-content table-responsive">

                            <table class="table table-bordered">
                                <th>Doctor</th>
                                <th>Specialty</th>
                                <th>Location</th>
                                <th>Contact Phone Number</th>
                                </thead>
                                <tbody>
                                <td><?php echo $row3['firstName']." ";?><?php echo $row3['lastName'];?></td>
                                <td><?php echo $row3['specialty'];?></td>
                                <td><?php echo $row3['location'];?></td>
                                <td><?php echo $row3['phone_no'];?></td>
                                <br>
                            </table>

                            <table class="table">
                                <thead class="text-primary">
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Price</th>
                                </thead>
                                <tbody>
                                <td><?php echo $row3['app_date'];?></td>
                                <td><?php echo $row3['start_time'];?></td>
                                <td><?php echo $row3['end_time'];?></td>
                                <td><?php echo "$".$row3['price'];?></td>
                                <br>
                                </tbody>
                            </table>
                            <div>
                                <form action="" method="POST">
                                    <button class="btn btn-medium btn-info" type="submit" name="btn-schedule<?php echo $i; ?>" style="text-align:right" color="blue">Schedule
                                </form>
                            </div><br><br>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>

        </nav>
    </ol>
</div>
</div>
</div>

</div>


</div>
</div>

</body>


</html>