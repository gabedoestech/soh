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

        /* navigation bar alignments */
         .inside-full-height {
          height: 100%;          
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
          <b>
      
<ul class="nav navbar-nav inside-full-height">
<li><a href="#">Home</a></li>
<li class="active"><a href="#">Profile<span class="sr-only">(current)</span></a></li>
<li><a href="createapp.php">Appointments</a></li>
<li><a href="help.php">Help</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>  
<ul class="nav navbar-right" id="log">
<li>Logged in as: <?php echo $row2['userName']; ?></li>
</ul>
</div><!-- /.navbar-collapse --></b>
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- OLD NAVBAR -->
    <div class="container">

        <ol class="breadcrumb ">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading"><b>Profile Information</b></div>
                <div class="panel-body">
                    <table class="table table-hover ">
                        <tbody>
                        <tr>
                            <th scope="row ">Username:</th>
                            <td colspan="2 ">
                                <?php echo $row2['userName']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Full Legal Name:</th>
                            <td>
                                <?php echo $row2['firstName']." "; ?>
                                <?php echo $row2['lastName']." "; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Specialty:</th>
                            <td colspan="2 ">
                                <?php echo $row3['specialty']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row ">Sex:</th>
                            <td colspan="2 ">
                                <?php echo $row2['sex']; ?>
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
                        </tbody>
                    </table>

                    <div align="right"><li><a href="editprofiledoctor.php"><button class="btn btn-medium btn-info"><b>Edit Profile Information</b></button></right></a></li>
                    </div>
                </div>
            </div>

      </ol>
      <br>
    </div>

    <center>
      <footer class="container-fluid" id="footer">
        <p>
          <h4>Copyright © Software Seals, 2017.</h4></p>
      </footer>
    </center>
  </body>


  </html>