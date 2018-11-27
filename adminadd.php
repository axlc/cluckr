<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Admin > Add Records");
  ?>
</head>
<body>

  <?php 
    include("snippets/nav.php");
  ?>

  <main>
    <?php 
      if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] && $_SESSION['plevel'] == 99)
      {
        if(!isset($_POST["adminAdd"]))
        {
          include("snippets/adminaddform.php");
        }
        else 
        {
          $host = "localhost";
          $user = "dbuser";
          $pass = "dbpass";
          $dbname = "dbname";
          $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
                   or die("Error connecting to MariaDB. Error: " 
                   . mysqli_error($dbc));
          mysqli_select_db($dbc, $dbname);

          if($_POST['adminAdd'] == "addUser")
          {
            $userEmailInput    = mysqli_escape_string($dbc, $_POST['userEmail']);
            $userNameInput     = mysqli_escape_string($dbc, $_POST['userName']);
            $userPasswordInput = mysqli_escape_string($dbc, $_POST['password']);
            $plevel            = mysqli_escape_string($dbc, $_POST['plevel']);

            $query = "SELECT * FROM sem_pro_users WHERE userEmail = '$userEmailInput';";

            $results = mysqli_query($dbc, $query);
            if (mysqli_num_rows($results) == 0) 
            {
              // create the structure, fiddle with permissions
              $structure = "user/$userNameInput";
              if(!mkdir($structure))
              {
                die("Failed to create user structure. Please contact an administrator to continue.");
              }
              
              $mode = 777; // apache rwx, group rwx, world rwx
              chmod($structure, octdec($mode));

              // get ready to generate user profile
              $userContent = file_get_contents("snippets/user.php");
              $userToggle = file_get_contents("snippets/followToggle.php");
              
              // personalize it
              $userContent = strtr($userContent, array("XXXX_UNAME_XXXX" => "$userNameInput"));
              $userToggle  = strtr($userToggle , array("XXXX_UNAME_XXXX" => "$userNameInput"));

              // create it on the filesystem
              file_put_contents("user/$userNameInput/index.php", $userContent)
                or die("Failed to generate user profile. Please contact an administrator to continue.");

              file_put_contents("user/$userNameInput/followToggle.php", $userToggle)
                or die("Failed to generate user toggle. Please contact an administrator to continue.");

              // fiddle dem perms...
              chmod("user/$userNameInput/index.php", octdec($mode));
              chmod("user/$userNameInput/followToggle.php", octdec($mode));

              // insert the user into the database
              $query = "INSERT INTO sem_pro_users(userName, userEmail, password, plevel) 
                        VALUES ('".$userNameInput."', '".$userEmailInput."', '". $userPasswordInput."', '" . $plevel . "');";
              $results = mysqli_query($dbc, $query);
              
              // Display the thing!
              echo "
              <div class='container-fluid'>
                <div class='alert alert-success'>
                  <strong>Success!</strong>
                  <p>User Added!</p>
                </div>
              </div>
              ";

              // close it out
              mysqli_close($dbc);
            }
          }
          else if($_POST['adminAdd'] == "addCluck")
          {
            $userName = mysqli_escape_string($dbc, $_POST['userName']);
            $cluck  = mysqli_escape_string($dbc, $_POST['cluck']);
            
            $query = "SELECT * FROM sem_pro_users WHERE sem_pro_users.userName = '$userName';";
            $results = mysqli_query($dbc, $query);

            $userID = 0;
            if(mysqli_num_rows($results) == 1)
            {
              $row = mysqli_fetch_array($results);
              $userID = $row['userID'];

              $query = "INSERT INTO sem_pro_clucks(userID, cluck) VALUES('" . $userID . "', '" . $cluck . "');";
              $results = mysqli_query($dbc, $query);

              // Display the thing!
              echo "
              <div class='container-fluid'>
                <div class='alert alert-success'>
                  <strong>Success!</strong>
                  <p>Clucking Posted!</p>
                </div>
              </div>
              ";

              // close it out
              mysqli_close($dbc);
            }
            else
            {
              // Display the thing!
              echo "
              <div class='container-fluid'>
                <div class='alert alert-warning'>
                  <strong>FAILURE!</strong>
                  <p>Clucking Not Posted! Check your username, because somethings up there.!</p>
                </div>
              </div>
              ";

              // close it out
              mysqli_close($dbc);
            }
          }
          else if($_POST['adminAdd'] == "addFollowers")
          { 
            $currentUserName = mysqli_real_escape_string($dbc, $_POST['userName']);
            $followUserName  = mysqli_real_escape_string($dbc, $_POST['followingName']);

            if($currentUserName == $followUserName)
            {
              // Display the thing!
              echo "
              <div class='container-fluid'>
                <div class='alert alert-warning'>
                  <strong>FAILURE!</strong>
                  <p>Whoa! Users can't follow themselves! (I mean, technically they could if they made a second account for it, but that'd be weird, and we're trying to be an upstanding community here.</p>
                </div>
              </div>
              ";

              // close it out
              mysqli_close($dbc);
            }
            else
            {

              $currentUserID = 0;
              $followUserID = 0;

              $query = "SELECT sem_pro_users.userID FROM sem_pro_users WHERE sem_pro_users.userName = '$currentUserName';";

              $results = mysqli_query($dbc, $query);
              if (mysqli_num_rows($results) == 1)
              {
                $row = mysqli_fetch_array($results);
                $currentUserID = $row['userID'];
              }

              $query = "SELECT sem_pro_users.userID FROM sem_pro_users WHERE sem_pro_users.userName = '$followUserName';";
              
              $results = mysqli_query($dbc, $query);
              if (mysqli_num_rows($results) == 1)
              {
                $row = mysqli_fetch_array($results);
                $followUserID = $row['userID'];
              }

              if($currentUserID == 0 || $followUserID == 0)
              {
                // Display the thing!
                echo "
                <div class='container-fluid'>
                  <div class='alert alert-warning'>
                    <strong>FAILURE!</strong>
                    <p>Whoa! There was an issue with one of your userNames, check them both.</p>
                  </div>
                </div>
                ";

                // close it out
                mysqli_close($dbc);
              }
              else 
              {
                $query = "SELECT * FROM sem_pro_followers 
                          WHERE sem_pro_followers.userID = '$currentUserID' 
                          AND sem_pro_followers.followingID = '$followUserID';";
                $results = mysqli_query($dbc, $query);
                if (mysqli_num_rows($results) == 0) 
                {
                  // if the number of results returned was zero, that means that $currentUser is not following $followUserName

                  $query =  "INSERT INTO sem_pro_followers(userID, followingID) VALUES('$currentUserID', '$followUserID')";
                  $results = mysqli_query($dbc, $query);

                  // Display the thing!
                  echo "
                  <div class='container-fluid'>
                    <div class='alert alert-success'>
                      <strong>Success!</strong>
                      <p>First user now follows second user!</p>
                    </div>
                  </div>
                  ";

                  // close it out
                  mysqli_close($dbc);
                  
                }
                else 
                {
                  echo "
                  <div class='container-fluid'>
                    <div class='alert alert-info'>
                      <strong>Wait a second... I know you...</strong>
                      <p>First user already follows second user!</p>
                    </div>
                  </div>
                  ";
                  mysqli_close($dbc);
                } 
              }
            }
          }
          else 
          {
            // close it out
            mysqli_close($dbc);
            echo "<h1>INVALID TABLE NAME. USE THE FORM LUKE.</h1>";
          }
        }
      } // wow, this block stretched from line 18 to line 251
      else
      {
        header("Location: login.php?loginstatus=ua");
      }
    ?>
  </main>

  <?php 
    include("snippets/footer.php");
  ?>

</body>
</html>