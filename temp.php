<?php
$query3 = $user_home->runQuery("SELECT A.*, D.specialty, U.firstName, U.lastName, U.phone_no FROM appointment A, users U, doctor D
WHERE A.userID = $userID AND D.userID = $userID AND U.userID = $userID AND A.taken=0
GROUP BY A.appointment_id ORDER BY A.app_date, A.start_time ASC");
$query3->execute(array($_SESSION['userSession']));

$query4 = $user_home->runQuery("SELECT A.*, D.specialty, U.firstName AS doc_firstname, U.lastName AS doc_lastname, U.phone_no AS doc_phone_no, U2.firstName, U2.lastName, U2.userEmail, U2.phone_no
FROM appointment A, users U, users U2, doctor D, sees S
WHERE S.userID_doctor=$userID AND S.userID_patient=U2.userID AND U.userID=$userID
AND S.appointment_id=A.appointment_id AND D.userID=$userID
GROUP BY A.appointment_id ORDER BY A.app_date, A.start_time ASC");
$query4->execute(array($_SESSION['userSession'])); ?>

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
                        <td>
                            <?php echo $row4['firstName']." ";?>
                            <?php echo $row4['lastName'];?>
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
                            <button class="btn btn-medium btn-info" type="submit" name="btn-cancel<?php echo $i; ?>" style="text-align:right" color="blue">Delete
                        </form>
                    </div>
                    <br>
                    <br>
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
                        <td>
                            <?php echo $row5['firstName']." ";?>
                            <?php echo $row5['lastName'];?>
                        </td>
                        <td>
                            <?php echo $row5['userEmail'];?>
                        </td>
                        <td>
                            <?php echo $row5['phone_no'];?>
                        </td>
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
                        <td>
                            <?php echo $row5['doc_firstname']." ";?>
                            <?php echo $row5['doc_lastname']." ";?>
                        </td>
                        <td>
                            <?php echo $row5['specialty'];?>
                        </td>
                        <td>
                            <?php echo $row5['location'];?>
                        </td>
                        <td>
                            <?php echo $row5['doc_phone_no'];?>
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
                            <?php echo $row5['app_date'];?>
                        </td>
                        <td>
                            <?php echo $row5['start_time'];?>
                        </td>
                        <td>
                            <?php echo $row5['end_time'];?>
                        </td>
                        <td>
                            <?php echo "$".$row5['price'];?>
                        </td>
                        <br>
                        </tbody>
                    </table>
                    <div>
                        <form action="" method="POST">
                            <button class="btn btn-medium btn-info" type="submit" name="btn-takencancel<?php echo $i; ?>" style="text-align:right" color="blue">Cancel and Delete
                        </form>
                    </div>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <?php $i++; } ?>

</nav>

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