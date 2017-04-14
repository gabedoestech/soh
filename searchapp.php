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
$i = 1;

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$query = $user_home->runQuery("SELECT * FROM users WHERE userID = $userID ");
$query->execute(array($_SESSION['userSession']));
$row2 = $query->fetch(PDO::FETCH_ASSOC);

$query2 = $user_home->runQuery("SELECT A.*, D.userID, D.specialty, U.name, U.phone_no FROM appointment A, users U, doctor D 
                                    WHERE U.userID = A.userID AND D.userID = U.userID AND A.taken = 0 GROUP BY A.app_name");
$query2->execute(array($_SESSION['userSession']));
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
</head>

<body>

<div class="container ">

    <div class="backer">
        <center><img src="SH_T_trimmed.png" class="img-rounded" alt="Cinque Terre" width="304" height="236"></center>
    </div>

    <div class="container">

        </ul>
    </div>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="home.php">Profile</a></li>
        <li role="presentation" class="active"><a href="#">Search for Appointment</a></li>
        <li role="presentation"><a href="medicalhistory.html">Medical History</a></li>
        <li role="presentation"><a href="logout.php">Logout</a></li>

        <p class="navbar-text">Signed in as <?php echo $row2['userName']; ?></p>
    </ul>

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

                            <table class="table">
                                <thead class="text-primary">
                                <th>Doctor</th>
                                <th>Specialty</th>
                                <th>Location</th>
                                <th>Contact Phone Number</th>
                                </thead>
                                <tbody>
                                <td><?php echo $row3['name'];?></td>
                                <td><?php echo $row3['specialty'];?></td>
                                <td><?php echo $row3['location'];?></td>
                                <td><?php echo $row3['phone_no'];?></td>
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