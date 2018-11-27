<?php 
  if(isset($_REQUEST['userEmail']))
  {
    $emailInput = $_REQUEST['userEmail'];
    
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $email = mysqli_escape_string($dbc, $emailInput);

    $query = "SELECT userEmail FROM sem_pro_users
              WHERE userEmail = '$email';
              ";

    $results = mysqli_query($dbc, $query);

    mysqli_close($dbc);

    if (mysqli_num_rows($results) == 0) 
    {
      header($_SERVER["SERVER_PROTOCOL"] . " 200 Ok");
      exit();
    }
    else
    {
      header($_SERVER["SERVER_PROTOCOL"] . " 453 An account with that email address already exists!");
      exit();
    }
  }
  // Just pretend you're not here. They'll go away for sure.
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
 ?>