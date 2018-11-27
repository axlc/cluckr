<?php 
  if(isset($_REQUEST['userName']))
  {
    $uname = $_REQUEST['userName'];
    
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $query = "SELECT userName FROM sem_pro_users
              WHERE userName = '$uname';
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
      header($_SERVER["SERVER_PROTOCOL"] . " 452 That Username is Taken");
      exit();
    }
  }
  // Just pretend you're not here. They'll go away for sure.
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
 ?>