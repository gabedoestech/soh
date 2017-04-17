<!DOCTYPE html>
<head>
  <title>Search Tester</title>
  <style>
    .search
    {
        border: 1px solid black;
        padding: 5px 0px 5px 5px;
    }
  </style>
</head>
<body>
  <h2>Input the filter/sort you want to test</h2>

  <div class='search'>
    <form action="testSearch.php" method='post'>
      <span>Location</span>
      <input type='text' name="city">
      <h3>Filter</h3>
      <span>Price (Low)</span>
      <input type='text' name='priceLow' value='100'><br>
      <span>Price (High)</span>
      <input type='text' name='priceHigh' value='1000'><br>
      <span>Date</span>
      <input type='text' name='date' placeholder='yyyy/mm/dd'><br>
      <span>Doctor Name</span>
      <input type='text' paceholder='first last'><br>
      <span>App. Name</span>
      <input type='text' name='app_name'><br>
      <span>Specialty</span>
      <input type='text' name='specialty'><br>
      <span>Sex</span>
      <input type='checkbox' name='sex' value='Male'>Male
      <input type='checkbox' name='sex' value='Female'>Female
      <h3>Sort By</h3>
      <select name="sort">
        <option value="price">Price</option>
        <option value="date">Date</option>
      </select><br>
  </div><br>
  <input type="submit" value='Search'>
</form>
<?php

  require_once 'functions.php';
  require_once 'search.php';

  //We should add a 'city' attribute to Appointment and have location be just
  //the practice's address. Then we can just make it mandatory to search by city,
  //with specific location as an option.
  if (isset($_POST['city']) && !empty($_POST['city']))
  {
    $city = $_POST['city'];

    if (isset($_POST['doctor']) && !empty($_POST['doctor']))
      $doctor = $_POST['doctor'];

    if (isset($_POST['app_name']) && !empty($_POST['app_name']))
      $app_name = $_POST['app_name'];

    if (isset($_POST['priceLow']) && !empty($_POST['priceLow']))
      $priceLow = $_POST['priceLow'];

    if (isset($_POST['priceHigh']) && !empty($_POST['priceHigh']))
      $priceHigh = $_POST['priceHigh'];

    if (isset($_POST['specialty']) && !empty($_POST['specialty']))
      $specialty = $_POST['specialty'];

    if (isset($_POST['date']) && !empty($_POST['date']))
      $date = $_POST['date'];

    if (isset($_POST['sex']))
      $sex = $_POST['sex'];

    if (isset($_POST['sort']))
      $sort = $_POST['sort'];

    $result = doSearch($city, $doctor, $app_name, $priceLow,
                              $priceHigh, $specialty, $date, $sex, $sort);

    foreach ($result as $appointment)
    {
      $app_name = $appointment['app_name'];
      $doctor = $appointment['username'];
      $price = $appointment['price'];
      $date = $appointment['app_date'];
      echo "<p>Dr: $doctor - $app_name, price: $$price on $date</p>";
    }
  }
  else
      echo "<h3>You must at least input a location to search for appointments.</h3>";
?>

</body>
</html>
