<?php
  session_start();
  require_once 'class.user.php';
  require_once 'search.php';
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

  $patientID = $row3['userID'];

  if (isset($_GET['id']) && !empty($_GET['id']))
    $id = $_GET['id'];
  else
  {
      $user_home->redirect('searchapp_styleupdated.php');
  }

  $curr = date("Y-m-d");

  $result = queryMysql("SELECT A.*, D.specialty, U.userEmail, U.firstName, U.lastName, U.phone_no
                        FROM appointment A, doctor D, users U WHERE A.appointment_id = '$id'
                        AND D.userID = A.userID AND U.userID = D.userID");

  if (!$result->num_rows)
    $user_home->redirect('searchapp_styleupdated.php');

?>
<!doctype html>
<html>


<head>
    <title>Medical Records</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main2.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

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
            }}
        body {
            padding-top: 50px;
        }
        .dropdown.dropdown-lg .dropdown-menu {
            margin-top: -1px;
            padding: 6px 20px;
        }
        .input-group-btn .btn-group {
            display: flex !important;
        }
        .btn-group .btn {
            border-radius: 0;
            margin-left: -1px;
        }
        .btn-group .btn:last-child {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .btn-group .form-horizontal .btn[type="submit"] {
          border-top-left-radius: 4px;
          border-bottom-left-radius: 4px;
        }
        .form-horizontal .form-group {
            margin-left: 0;
            margin-right: 0;
        }
        .form-group .form-control:last-child {
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        @media screen and (min-width: 768px) {
            #adv-search {
                width: 500px;
                margin: 0 auto;
            }
            .dropdown.dropdown-lg {
                position: static !important;
            }
            .dropdown.dropdown-lg .dropdown-menu {
                min-width: 500px;
                background-color: #fff;
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
    <li class="active"><a href="searchapp_styleupdated.php">Appointments<span class="sr-only">(current)</span></a></li>
    <li><a href="help.php">Help</a></li>
    <li><a href="logout.php">Logout</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right" id="log">
    <li>Logged in as: <?php echo $row2['userName']; ?></li>
    </ul>
  </div><!-- /.navbar-collapse --></b>
  </div> <!-- /.container-fluid -->
    </nav>

<?php

      $row3       = $result->fetch_array();
      $name       = $row3['firstName'] . " " . $row3['lastName'];
      $specialty  = $row3['specialty'];
      $address    = $row3['location'];
      $phone_no   = $row3['phone_no'];
      $app_date   = $row3['app_date'];
      $start_time = $row3['start_time'];
      $end_time   = $row3['end_time'];
      $price      = $row3['price'];
      $app_id         = $row3['appointment_id'];

      if (isset($_POST['confirm']) && !empty($_POST['confirm']))
      {
        $result = queryMysql("SELECT S.* FROM appointment A, patient P, sees S WHERE
                              S.appointment_id = '$id' AND S.userID_patient <> '$patientID'
                              AND A.taken = '1'");

        $result2 = queryMysql("SELECT S.* FROM sees S, appointment A WHERE
                              A.appointment_id = '$id' AND S.userID_patient = '$patientID'
                              AND A.userID = S.userID_doctor AND A.taken = '1'");

        $result3 = queryMysql("SELECT A.* FROM appointment A WHERE
                              A.appointment_id = '$id' AND A.app_date < '$curr'
                              AND A.taken = '0'");
                          
        if ($result->num_rows)
        {
          ?>

          <div class="alert alert-danger" role="alert">
            <strong>OH NO!</strong> This appointment has already been taken!
          </div>

        <?php }
          elseif ($result2->num_rows)
          {
        ?>
          <div class="alert alert-warning" role="alert">
            <strong>Relax!</strong> You are already scheduled for this appointment!
          </div>

        <?php
          }
          elseif ($result3->num_rows)
          {
        ?>
          <div class="alert alert-danger" role="alert">
            <strong>OH NO!</strong> You can no longer schedule this appointment!
          </div>

        <?php
          }
          else
          {
            queryMysql("UPDATE appointment set taken = '1' WHERE appointment_id = '$id'");
            $result = queryMysql("SELECT D.userID FROM doctor D, appointment A WHERE
                                  A.appointment_id = '$id' AND A.userID = D.userID");
            $result   = $result->fetch_array();
            $doctorID = $result['userID'];

            queryMysql("INSERT INTO sees VALUES('$patientID', '$doctorID', '$id')");
        ?>

      <div class="alert alert-success" role="alert">
        <strong>Well done!</strong> You are now scheduled for this appointment.
      </div>

    <?php }} ?>


    <div class="panel panel-default">
        <div class="panel-heading" id="ph"><b>Confirm Appointment</b></div>
        <div class="panel-body">
          <table id='$id' class='table table-bordered'>
        <tr>
              <th>Doctor</th>
              <th>Specialty</th>
              <th>Location</th>
              <th>Contact Phone Number</th>
        </tr>
        <tr>
              <td><?php echo $name;?></td>
              <td><?php echo $specialty;?></td>
              <td><?php echo $address;?></td>
              <td><?php echo $phone_no;?></td>
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
               <td><?php echo $app_date;?></td>
               <td><?php echo $start_time;?></td>
               <td><?php echo $end_time;?></td>
               <td><?php echo $price;?></td>
           </tr>
         </table>

         <div align="right">
           <?php
             echo "<form action='confirm_app.php?id=$id' method='post'>";
           ?>
              <button class="btn btn-medium btn-info" type="submit" name="confirm" value="confirm" style="text-align:right" color="blue">Confirm Appointment</button>
          </form>
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
