<?php
  $dbhost  = 'localhost';
  $dbname  = 'SealOfHealth';
  $dbuser  = 'root';
  //Put whatever password you set for root when you installed mysql
  //into <dbpass>. Everything else should be good (I think)
  $dbpass  = '0000';

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);

  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }

?>
