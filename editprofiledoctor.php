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

if(isset($_POST['btn-save']))
{
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $specialty = trim($_POST['specialty']);
    $sex = trim($_POST['sex']);
    $address = trim($_POST['address']);
    $phone_no = trim($_POST['phone_no']);

    if($user_home->updateUser($userID, $firstName, $lastName, $sex, $address, $phone_no) && $user_home->updateDoctor($userID, $specialty))
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

    <ol class="breadcrumb" id="bc1">
        <br>
        <div class="panel panel-default">
            <div class="panel-heading"><b>Profile Information</b></div>
            <div class="panel-body">
                <form action="" method="POST">
            <!-- Profile Information: User input -->
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Username:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $row2['userName']; ?>
                    </p>
                    <small id="helpInline" class="text-muted">
                        (If you need to change your username, please contact the administrator)
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $row2['userEmail']; ?>
                    </p>
                    <small id="helpInline" class="text-muted">
                        (If you need to change your email, please contact the administrator)
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label for="nameInput" class="col-sm-2 col-sm-form-label">First Name:</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" placeholder="Enter your first name" name="firstName" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nameInput" class="col-sm-2 col-sm-form-label">Last Name:</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" placeholder="Enter your last name" name="lastName" required>
                </div>
            </div>

            <!-- ADD DATE PICKER LATER TO MAKE ENTRY FANCY -->
            <div class="form-group row">
                <label for="birthdayInput" class="col-sm-2 col-sm-form-label">Specialty:</label>
                <select name="specialty">
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

            <div class="form-group row">
                <label for="sexInput" class="col-sm-2 col-sm-form-label">Sex:</label>
                <div class="col-sm-4">
                    <label class="radio-inline"><input type="radio" name="sex" <?php if (isset($sex) && $sex=="male") echo "checked";?> value="Male" required>Male</label>
                    <label class="radio-inline"><input type="radio" name="sex" <?php if (isset($sex) && $sex=="female") echo "checked";?> value="Female">Female</label>
                </div>
            </div>

            <div class="form-group row">
                <label for="addressInput" class="col-sm-2 col-sm-form-label">Address:</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" name="address" placeholder="Enter your full office address" id="example-name-input" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="phoneInput" class="col-sm-2 col-sm-form-label">Phone Number:</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text" name="phone_no" placeholder="Enter your office's contact phone number" id="example-name-input" required>
                </div>
            </div>

                    <div align="right"><button class="btn btn-medium btn-info" type="submit" name='btn-save'><b>Save Profile</b></button></div>
                </form>


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