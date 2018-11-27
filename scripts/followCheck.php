<?php 
  if(isset($_REQUEST['currentUser']) && isset($_REQUEST['followName']))
  {
    $currentUserInput = $_REQUEST['currentUser'];
    $followNameInput = $_REQUEST['followName'];
    
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $currentUser = mysqli_escape_string($dbc, $currentUserInput);
    $followName = mysqli_escape_string($dbc, $followNameInput);

    $query = "SELECT sem_pro_followers.userID, sem_pro_followers.followingID
              FROM sem_pro_users
              INNER JOIN sem_pro_followers 
              ON (sem_pro_followers.followingID = sem_pro_users.userID)
              WHERE sem_pro_users.userName = '$followName'
              AND sem_pro_followers.userID = '$currentUser'
              LIMIT 1
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
      header($_SERVER["SERVER_PROTOCOL"] . " 454 Current user already follows selected user");
      exit();
    }
  }
  // Just pretend you're not here. They'll go away for sure.
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
 ?>