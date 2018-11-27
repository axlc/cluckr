<?php 
  if(isset($_POST['toggleFollow']))
  {
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $currentUser = mysqli_real_escape_string($dbc, $_POST['currentUser']);
    $followUserName  = mysqli_real_escape_string($dbc, $_POST['followUser']);

    // Returns a list of users who follow $followUserName and who also have userID = $currentUser
    $query = "SELECT sem_pro_followers.userID, sem_pro_followers.followingID
              FROM sem_pro_users
              INNER JOIN sem_pro_followers 
              ON (sem_pro_followers.followingID = sem_pro_users.userID)
              WHERE sem_pro_users.userName = '$followUserName'
              AND sem_pro_followers.userID = '$currentUser'
              LIMIT 1
              ";

    $results = mysqli_query($dbc, $query);
    if (mysqli_num_rows($results) == 0) 
    {
      // if the number of results returned was zero, that means that $currentUser is not following $followUserName
      $query =  "SELECT sem_pro_users.userID
                 FROM sem_pro_users
                 WHERE sem_pro_users.userName = '$followUserName'
                 ";
      $results = mysqli_query($dbc, $query);

      if(mysqli_num_rows($results) > 0)
      {
        $row = mysqli_fetch_array($results);
        $followUser = $row['userID'];

        $query =  "INSERT INTO `amccracken`.`sem_pro_followers` (`userID`, `followingID`) VALUES ('$currentUser', '$followUser')";
        echo "$query";
        $results = mysqli_query($dbc, $query);


        mysqli_close($dbc);
        header("Location: " . $_POST['referrer'] . "?followToggleStatus=followAdded");
      }
      else 
      {
        mysqli_close($dbc);
        header("Location: " . $_POST['referrer'] . "?followToggleStatus=invalidUser");
      }
    }
    else 
    {
      // if the number of results returned was > zero, that means that $currentUser is already following $followUserName
      $query =  "SELECT sem_pro_users.userID
                 FROM sem_pro_users
                 WHERE sem_pro_users.userName = '$followUserName'
                 ";
      $results = mysqli_query($dbc, $query);

      if(mysqli_num_rows($results) > 0)
      {
        $row = mysqli_fetch_array($results);
        $followUser = $row['userID'];

        $query =  "DELETE FROM sem_pro_followers WHERE userID = '$currentUser' AND followingID = '$followUser'";
        echo "$query";
        $results = mysqli_query($dbc, $query);

        mysqli_close($dbc) or die("error somehow");
        header("Location: " . $_POST['referrer'] . "?followToggleStatus=followRemoved");
      }
      else 
      {
        mysqli_close($dbc);
        header("Location: " . $_POST['referrer'] . "?followStatus=invalidUser");
      }
    }
  }
  else
  {
    header("Location: ../");
  }
 ?>