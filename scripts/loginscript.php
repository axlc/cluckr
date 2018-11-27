<?php 
  if(isset($_POST['submit']))
  {
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $userNameInput = mysqli_real_escape_string($dbc, $_POST['userName']);
    $passwordInput = mysqli_real_escape_string($dbc, $_POST['userPass']);

    $query = "SELECT * FROM sem_pro_users
              WHERE userName = '$userNameInput'
              AND password = '$passwordInput'";

    $results = mysqli_query($dbc, $query);

    mysqli_close($dbc);

    if (mysqli_num_rows($results) > 0) 
    {
      $row = mysqli_fetch_array($results);
      session_start();
      $_SESSION['userID']         = $row['userID'];
      $_SESSION['userName']       = $row['userName'];
      $_SESSION['userEmail']      = $row['userEmail']; // TODO: Do I need this to remain in the session? Not sure, will reconsider...
      $_SESSION['userAvatarPath'] = $row['userAvatarPath'];
      $_SESSION['plevel']         = $row['plevel'];

      $_SESSION['loggedIn'] = true;
      $_SESSION['timeout'] = time();

    header("Location: ../userhome.php");
    exit();
    } 
    else 
    {
      header("Location: ../login.php?loginstatus=fail");
      exit();
    }
  }
  else
  {
    header("Location: ../login.php?loginstatus=ua");
    exit();
  }
?>