<!DOCTYPE html>
<html lang="en">
<head>
  <title>Title Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="main2.css">

        
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
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
        <div >
        <div class="mylogo">
            <center><img class="logo-img img-responsive" src="Design2.png"></center>
        </div>

        <!-- NEW NAVBAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        
        <ul class="nav navbar-nav">
        <li><a href="index2.php">Login</a></li>        
        
        
        
            </li>
        <!--End Dropdown for appointments -->

        <li><a href="faq.html">Help</a></li>        
        </ul>

            
      </div> <!-- /.container-fluid -->
    </nav>
        <br>
<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="doctors.jpg" alt="Chania" width="460" height="345">
        <div class="carousel-caption">
        </div>
      </div>

      <div class="item">
        <img src="health.jpg" alt="Chania" width="460" height="345">
        <div class="carousel-caption">
        </div>
      </div>
    
      <div class="item">
        <img src="babyseal.jpg" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
        </div>
      </div>

      <div class="item">
        <img src="seals.jpg" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<br>
<center>
   
    
      <footer class="container-fluid" id="footer">
        <p>
          <h4>Copyright © Software Seals, 2017.</h4></p>
      </footer>
</body>
</html>
