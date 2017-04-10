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
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <li class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Profile</a></li>
        <li role="presentation"><a href="medicalhistory.html">Medical History</a></li>
        <li role="presentation"><a href="logout.php">Logout</a></li>

        <p class="navbar-text">Signed in as Maria Mosquera</p>
    </ul>

    <ol class="breadcrumb ">


        <br>
        <li><a href="editprofilepatient.php">Edit Profile Information</a>></li>>
        <li><a href="# ">View Profile</a></li>
        </br>


        <h2>User Profile</h2>
        <br>
        <table class="table table-hover ">
            <tbody>
            <tr>
                <th scope="row ">Username:</th>
                <td colspan="2 ">mariamosquera</td>
            </tr>
            <tr>
                <th scope="row ">Full Legal Name:</th>
                <td>Maria</td>
            </tr>
            <tr>
                <th scope="row ">Date of Birth:</th>
                <td>4/10/2017</td>
            </tr>
            <tr>
                <th scope="row ">Sex:</th>
                <td colspan="2 ">Female</td>
            </tr>
            <tr>
                <th scope="row ">Race/Ethnicity:</th>
                <td colspan="2 ">Hispanic</td>
            </tr>
            <tr>
                <th scope="row ">Address:</th>
                <td colspan="2 ">1234 Idont Remember Drive, Orlando, FL, 33333</td>
            </tr>
            <tr>
                <th scope="row ">Phone Number:</th>
                <td colspan="2 ">445-454-4455</td>
            </tr>
            <tr>
                <th scope="row ">Email Adress:</th>
                <td colspan="2 ">sealofhealth@gmail.com</td>
            </tr>
            </tbody>
        </table>

        <h2>Appointments</h2>

        <h2>Medical Records</h2>

    </ol>
</div>
</div>
</div>

</div>


</div>
</div>

</body>


</html>