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

  if (isset($_POST['city']) && !empty($_POST['city']))
  {
    $city        = $_POST['city'];

    if (isset($_POST['first']) && !empty($_POST['first']))
      $first     = $_POST['first'];

    if (isset($_POST['last']) && !empty($_POST['last']))
      $last      = $_POST['last'];

    if (isset($_POST['name']) && !empty($_POST['name']))
      $app_name  = $_POST['name'];

    if (isset($_POST['priceLow']) && !empty($_POST['priceLow']))
      $priceLow  = $_POST['priceLow'];

    if (isset($_POST['priceHigh']) && !empty($_POST['priceHigh']))
      $priceHigh = $_POST['priceHigh'];

    if (isset($_POST['specialty']) && !empty($_POST['specialty']))
      $specialty = $_POST['specialty'];

    if (isset($_POST['date']) && !empty($_POST['date']))
      $date      = $_POST['date'];

    if (isset($_POST['sex']))
      $sex       = $_POST['sex'];

    if (isset($_POST['sort']))
      $sort      = $_POST['sort'];

    $result      = doSearch($city, $first, $last, $app_name, $priceLow,
                       $priceHigh, $specialty, $date, $sex, $sort);

  }

?>

    <!DOCTYPE html>
    <html>
    <head>
		<meta http-equive"refresh" content="600">
         <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        <!-- added a class in css - logo-img -->
       <div class="mylogo">
            <center><img class="logo-img img-responsive" src="Design2.png"></center>
        </div>

        <!-- NEW NAVBAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class="nav navbar-nav inside-full-height">
                    <li><a href="home.php">Home</a></li>
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
                </ul>

                <ul class="nav navbar-nav navbar-right" id="log">
                    <li><a  style="color:#03CCFE" href="#">Logged in as: <?php echo $row2['userName']; ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>

      </div><!-- /.navbar-collapse --></b>
      </div> <!-- /.container-fluid -->
        </nav>




        <!-- OLD NAVBAR -->
    <div class="container">
      <div class="container">
	       <div class="row">
	         <div class="col-xs-12">
             <div class="input-group" id="adv-search">
               <input type="text" required="true" form="myform" class="form-control" name="city" placeholder="City" value='<?php echo $city;?>'/>
               <div class="input-group-btn">
                <div class="btn-group" role="group">
                  <div class="dropdown dropdown-lg">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <form id="myform" class="form-horizontal" role="form" action="searchapp_styleupdated.php" method="post">
                      <div class="form-group">
                        <label for="filter">Sort by</label>
                          <select class="form-control" name="sort">
                            <option value="date" selected>Date</option>
                            <option value="price">Price</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="contain">Date</label>
                          <input class="form-control" type="date" data-provide="datepicker" name="date"/>
                        </div>
                        <div class="form-group">
                          <label for="contain">Price</label>
                          <input class="form-control" type="number" name="priceLow" min="100" max="10000" step="100" placeholder="Low"/>
                          <input class="form-control" type="number" name="priceHigh" min="100" max="10000" step="100" placeholder="High"/>
                        </div>
                      <div class="form-group">
                        <label for="contain">Doctor</label>
                        <input class="form-control" type="text" name="first" placeholder="First name"/>
                        <input class="form-control" type="text" name="last" placeholder="Last name"/>
                      </div>
                      <div class="form-group">
                        <label for="contain">App. Name</label>
                        <input class="form-control" type="text" name="name"/>
                      </div>
                      <div class="form-group">
                        <label for="contain">Specialty</label>
                      <select name="specialty" class="form-control">
                        <option value=""></option>
                        <option value="Allergology">Allergology</option>
                        <option value="Andrology">Andrology</option>
                        <option value="Angiology">Angiology</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="Dentistry">Dentistry</option>
                        <option value="Dermatology">Dermatology</option>
                        <option value="Emergency Medicine">Emergency Medicine</option>
                        <option value="Endocrinology">Endocrinology</option>
                        <option value="Family Medicine">Family Medicine</option>
                        <option value="Gastoenterology">Gastoenterology</option>
                        <option value="General Practice">General Practice</option>
                        <option value="Medical Genetics">Medical Genetics</option>
                        <option value="Geriatrics">Geriatrics</option>
                        <option value="Gerontology">Gerontology</option>
                        <option value="Gynaecology">Gynaecology</option>
                        <option value="Hematology">Hematology</option>
                        <option value="Hepatology">Hepatology</option>
                        <option value="Immunology">Immunology</option>
                        <option value="Infectious Diseases">Infectious Diseases</option>
                        <option value="Intensive Care Medicine">Intensive Care Medicine</option>
                        <option value="Internal Medicine">Internal Medicine</option>
                        <option value="Men's Health">Men's Health</option>
                        <option value="Nephrology">Nephrology</option>
                        <option value="Neurology">Neurology</option>
                        <option value="Nuclear Medicine">Nuclear Medicine</option>
                        <option value="Obstetrics">Obstetrics</option>
                        <option value="Oncology">Oncology</option>
                        <option value="Ophthalmology">Ophthalmology</option>
                        <option value="Otorhinolaryngology (ENT)">Otorhinolaryngology (ENT)</option>
                        <option value="Pallative Medicine">Pallative Medicine</option>
                        <option value="Pathology">Pathology</option>
                        <option value="Pediatrics">Pediatrics</option>
                        <option value="Podiatry">Podiatry</option>
                        <option value="Preventative Medicine">Preventative Medicine</option>
                        <option value="Psychiatry">Psychiatry</option>
                        <option value="Pulmonology">Pulmonology</option>
                        <option value="Radiology">Radiology</option>
                        <option value="Rehabilitation Medicine">Rehabilitation Medicine</option>
                        <option value="Rheumatology">Rheumatology</option>
                        <option value="Serology">Serology</option>
                        <option value="Sexual Health">Sexual Health</option>
                        <option value="Sleep Medicine">Sleep Medicine</option>
                        <option value="Sports Medicine">Sports Medicine</option>
                        <option value="Surgery">Surgery</option>
                        <option value="Toxicology">Toxicology</option>
                        <option value="Transplantation Medicine">Transplantation Medicine</option>
                        <option value="Trichology">Trichology</option>
                        <option value="Tropical Medicine">Tropical Medicine</option>
                        <option value="Urology">Urology</option>
                        <option value="Other">Other</option>
                      </select>
                      </div>
                      <div class="form-group">
                        <label for="filter">Doctor Gender</label>
                          <select class="form-control" name="sex">
                            <option value="" selected></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>                   
                  </form>
                  </div>
                </div>
                <button type="submit" form="myform" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div></div>


            <ol class="breadcrumb col-xs-10 col-xs-offset-1" id="bc1">
                <br>
                
                <div class="panel panel-default ">
                    <div class="panel-heading" id="ph"><b>Appointments</b></div>
                    <div class="panel-body">

                  <!-- Add carousel here for potential appointment candidates -->

                  <br><br>

                  <?php

                  foreach($result as $row3)
                  {
                    $app_name = $row3['app_name'];
                    $name       = $row3['firstName'] ." ". $row3['lastName'];
                    $specialty  = $row3['specialty'];
                    $address    = $row3['location'];
                    $phone_no   = $row3['phone_no'];
                    $app_date   = $row3['app_date'];
                    $start_time = $row3['start_time'];
                    $end_time   = $row3['end_time'];
                    $price      = $row3['price'];
                    $id         = $row3['appointment_id'];
                    echo "<table id='$id' class='table table-bordered'>";
                  ?>
                  <tr>
                    <th><?php echo "$app_name"?></th>
                  </tr>
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
                        <button class="btn btn-medium btn-info" type="submit" style="text-align:right" name='schedule' color="blue">Schedule</button>
                    </form>
                  </div><br><hr><br>
                  <?php } ?>
                    </div>
                 </div>                 
    </ol>
</div>

	<!-- Export a Table to PDF - END -->


</body>




</html>
