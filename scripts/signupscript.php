<?php 
  if(isset($_POST['submit']))
  {
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect($host, $user, $pass)
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $userNameInput = mysqli_real_escape_string($dbc, $_POST['userName']);
    $userEmailInput = mysqli_real_escape_string($dbc, $_POST['userEmail']);
    $userPasswordInput = mysqli_real_escape_string($dbc, $_POST['userPass1']);

    $query = "SELECT * FROM sem_pro_users
              WHERE userEmail = '$userEmailInput';
              ";

    $results = mysqli_query($dbc, $query);

    if (mysqli_num_rows($results) == 0) 
    {
      // create the structure, fiddle with permissions
      $structure = "../user/$userNameInput";
      if(!mkdir($structure)) {
        die("Failed to create user structure. Please contact an administrator to continue.");
      }
      
      $mode = 777; // apache rwx, group rwx, world rwx
      chmod($structure, octdec($mode));

      // get ready to generate user profile
      $userContent = file_get_contents("../snippets/user.php");
      $userToggle = file_get_contents("../snippets/followToggle.php");
      
      // personalize it
      $userContent = strtr($userContent, array("XXXX_UNAME_XXXX" => "$userNameInput"));
      $userToggle  = strtr($userToggle , array("XXXX_UNAME_XXXX" => "$userNameInput"));

      // create it on the filesystem
      file_put_contents("../user/$userNameInput/index.php", $userContent)
        or die("Failed to generate user profile. Please contact an administrator to continue.");

      file_put_contents("../user/$userNameInput/followToggle.php", $userToggle)
        or die("Failed to generate user toggle. Please contact an administrator to continue.");

      // fiddle dem perms...
      chmod("../user/$userNameInput/index.php", octdec($mode));
      chmod("../user/$userNameInput/followToggle.php", octdec($mode));

      // insert the user into the database
      $query = "INSERT INTO sem_pro_users(userName, userEmail, password) VALUES ('".$userNameInput."', '".$userEmailInput."', '".$userPasswordInput."');";
      $results = mysqli_query($dbc, $query);
      
      // close it out
      mysqli_close($dbc);

      echo "head on home little chicken...you're free now.";
      header("Location: ../signup.php?signupstatus=success");
    }
    else 
    {
      mysqli_close($dbc);
      header("Location: ../signup.php?signupstatus=fail");
    }
  }
  else
  {
    header("Location: ../signup.php?signupstatus=ua");
  }
?>