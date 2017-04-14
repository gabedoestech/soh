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

$query2 = $user_home->runQuery("SELECT * FROM doctor WHERE userID = $userID ");
$query2->execute(array($_SESSION['userSession']));
$row3 = $query2->fetch(PDO::FETCH_ASSOC);

$query3 = $user_home->runQuery("SELECT A.*, D.specialty, U.name, U.phone_no FROM appointment A, users U, doctor D 
                                    WHERE A.userID = $userID AND D.userID = $userID AND U.userID = $userID AND A.taken=0 
                                    GROUP BY A.appointment_id ORDER BY A.app_date, A.start_time ASC");
$query3->execute(array($_SESSION['userSession']));

$query4 = $user_home->runQuery("SELECT A.*, D.specialty, U.name AS doc_name, U.phone_no AS doc_phone_no, U2.name, U2.userEmail, U2.phone_no 
                                    FROM appointment A, users U, users U2, doctor D, sees S 
                                    WHERE S.userID_doctor=$userID AND S.userID_patient=U2.userID AND U.userID=$userID 
                                    AND S.appointment_id=A.appointment_id AND D.userID=$userID
                                    GROUP BY A.appointment_id ORDER BY A.app_date, A.start_time ASC");
$query4->execute(array($_SESSION['userSession']));
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
        <li role="presentation" class="active"><a href="#">Profile</a></li>
        <li role="presentation"><a href="createapp.php">Create Appointment</a></li>
        <li role="presentation"><a href="logout.php">Logout</a></li>

        <p class="navbar-text">Signed in as <?php echo $row2['userName']; ?></p>
    </ul>

    <ol class="breadcrumb ">


        <br>
        <li><a href="editprofiledoctor.php">Edit Profile Information</a></li>
        <li><a href="# ">View Profile</a></li>
        </br>


        <h2>User Profile</h2>
        <br>
        <table class="table table-hover ">
            <tbody>
            <tr>
                <th scope="row ">Username:</th>
                <td colspan="2 "><?php echo $row2['userName']; ?></td>
            </tr>
            <tr>
                <th scope="row ">Full Legal Name:</th>
                <td><?php echo $row2['name']; ?></td>
            </tr>
            <tr>
                <th scope="row ">Specialty:</th>
                <td colspan="2 "><?php echo $row3['specialty']; ?></td>
            </tr>
            <tr>
                <th scope="row ">Sex:</th>
                <td colspan="2 "><?php echo $row2['sex']; ?></td>
            </tr>
            <tr>
                <th scope="row ">Address:</th>
                <td colspan="2 "><?php echo $row2['address']; ?></td>
            </tr>
            <tr>
                <th scope="row ">Phone Number:</th>
                <td colspan="2 "><?php echo $row2['phone_no']; ?></td>
            </tr>
            <tr>
                <th scope="row ">Email Adress:</th>
                <td colspan="2 "><?php echo $row2['userEmail']; ?></td>
            </tr>
            </tbody>
        </table>

        <h2>Unscheduled Appointments</h2>
        <br>
        <nav class="navbar navbar-transparent navbar-absolute">

            <?php
            while ($row4 = $query3->fetch(PDO::FETCH_ASSOC))
            {
                $button1 = "btn-cancel".$i;
                $appID = $row4['appointment_id'];

                if(isset($_POST[$button1]))
                {
                    if($user_home->deleteAppointment($appID))
                    {
                        echo " yay you did it";
                        $user_home->redirect('doctorhome.php');
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
                            <h4 class="title"><?php echo $row4['app_name']; ?></h4>
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
                                <td><?php echo $row4['name'];?></td>
                                <td><?php echo $row4['specialty'];?></td>
                                <td><?php echo $row4['location'];?></td>
                                <td><?php echo $row4['phone_no'];?></td>
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
                                <td><?php echo $row4['app_date'];?></td>
                                <td><?php echo $row4['start_time'];?></td>
                                <td><?php echo $row4['end_time'];?></td>
                                <td><?php echo "$".$row4['price'];?></td>
                                <br>
                                </tbody>
                            </table>
                            <div>
                                <form action="" method="POST">
                                    <button class="btn btn-medium btn-info" type="submit" name="btn-cancel<?php echo $i; ?>" style="text-align:right" color="blue">Delete
                                </form>
                            </div><br><br>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>

        </nav>

        <h2>Scheduled Appointments</h2>
        <br>
        <nav class="navbar navbar-transparent navbar-absolute">

            <?php
            while ($row5 = $query4->fetch(PDO::FETCH_ASSOC))
            {
                $button2 = "btn-takencancel".$i;
                $appID = $row5['appointment_id'];

                if(isset($_POST[$button2]))
                {
                    $name = $row5['app_name'];
                    $stime = "".$row5['start_time'];
                    $etime = "".$row5['end_time'];
                    $date = "".$row5['app_date'];
                    $email = "".$row2['userEmail'];

                    if($user_home->deleteAppointment($appID))
                    {
                        /*$message = "
                        Hello,
                        <br /><br />
                        The appointment, $name, scheduled from $stime to $etime on $date has been canceled by your chosen
                        doctor. If you would like, please select another available appointment.
                        <br /><br />
                        Thank you,
                            Seal of Health Team
                        ";
                        $subject = "Appointment Cancellation - ".$name;
                        $reg_user->send_mail($email,$message,$subject);*/
                        echo " yay you did it";
                        $user_home->redirect('doctorhome.php');
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
                            <h4 class="title"><?php echo $row5['app_name']; ?></h4>
                        </div>
                        <div class="card-content table-responsive">

                            <table class="table">
                                <thead class="text-primary">
                                <th>Patient</th>
                                <th>Email</th>
                                <th>Contact Phone Number</th>
                                </thead>
                                <tbody>
                                <td><?php echo $row5['name'];?></td>
                                <td><?php echo $row5['userEmail'];?></td>
                                <td><?php echo $row5['phone_no'];?></td>
                                <br>
                                </tbody>
                            </table>

                            <table class="table">
                                <thead class="text-primary">
                                <th>Doctor</th>
                                <th>Specialty</th>
                                <th>Location</th>
                                <th>Contact Phone Number</th>
                                </thead>
                                <tbody>
                                <td><?php echo $row5['doc_name'];?></td>
                                <td><?php echo $row5['specialty'];?></td>
                                <td><?php echo $row5['location'];?></td>
                                <td><?php echo $row5['doc_phone_no'];?></td>
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
                                <td><?php echo $row5['app_date'];?></td>
                                <td><?php echo $row5['start_time'];?></td>
                                <td><?php echo $row5['end_time'];?></td>
                                <td><?php echo "$".$row5['price'];?></td>
                                <br>
                                </tbody>
                            </table>
                            <div>
                                <form action="" method="POST">
                                    <button class="btn btn-medium btn-info" type="submit" name="btn-takencancel<?php echo $i; ?>" style="text-align:right" color="blue">Cancel and Delete
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