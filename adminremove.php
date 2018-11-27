<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Admin > Remove Records");
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
        if(!isset($_POST["adminRemove"]))
        {
          include("snippets/adminremoveform.php");
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

          if($_POST['adminRemove'] == "removeUser")
          {
            $userNameInput = mysqli_escape_string($dbc, $_POST['userName']);

            $query = "SELECT sem_pro_users.userID FROM sem_pro_users WHERE sem_pro_users.userName = '$userNameInput';";
            $results = mysqli_query($dbc, $query);

            if(mysqli_num_rows($results) == 1)
            {
              $row = mysqli_fetch_array($results);
              $userID = $row['userID'];

              // Delete their clucks
              $query   = "DELETE FROM sem_pro_clucks WHERE sem_pro_clucks.userID = '$userID';";
              $results = mysqli_query($dbc, $query);

              // Delete their follows
              $query   = "DELETE FROM sem_pro_follows WHERE sem_pro_clucks.userID = '$userID' OR sem_pro_clucks.followingID = '$userID';";
              $results = mysqli_query($dbc, $query);

              // Delete their user info
              $query   = "DELETE FROM sem_pro_users WHERE sem_pro_users.userID = '$userID';";
              $results = mysqli_query($dbc, $query);

              // delete their user directory
              $dir   = 'user' . DIRECTORY_SEPARATOR . "$userNameInput";
              $it    = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
              $files = new RecursiveIteratorIterator($it,
                           RecursiveIteratorIterator::CHILD_FIRST);

              foreach($files as $file) {
                if ($file->isDir())
                {
                  rmdir($file->getRealPath());
                }
                else 
                {
                  unlink($file->getRealPath());
                }
              }
              rmdir($dir);
                
              // Display the thing!
              echo "
              <div class='container-fluid'>
                <div class='alert alert-success'>
                  <strong>Success!</strong>
                  <p>User, Clucks, Follows and Directory Deleted!</p>
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
                  <p>There's no user by that name!</p>
                </div>
              </div>
              ";

              // close it out
              mysqli_close($dbc);
            }
          } 
          else if($_POST['adminRemove'] == "removeCluck")
          {
            $cluckID = mysqli_escape_string($dbc, $_POST['cluckID']);
            
            $query = "SELECT * FROM sem_pro_clucks WHERE sem_pro_clucks.cluckID = '$cluckID';";
            $results = mysqli_query($dbc, $query);

            if(mysqli_num_rows($results) == 1)
            {
              // Delete the cluck
              $query   = "DELETE FROM sem_pro_clucks WHERE sem_pro_clucks.cluckID = '$cluckID';";
              $results = mysqli_query($dbc, $query);
                
              // Display the thing!
              echo "
              <div class='container-fluid'>
                <div class='alert alert-success'>
                  <strong>Success!</strong>
                  <p>Clucks Deleted!</p>
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
                  <p>There's no cluck by that ID!</p>
                </div>
              </div>
              ";

              // close it out
              mysqli_close($dbc);
            }
          }
          else if($_POST['adminRemove'] == "removeFollowers")
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
                  <p>Whoa! Users can't follow themselves, so it's going to be super difficult to let them unfollow themselves.</p>
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
                if (mysqli_num_rows($results) == 1) 
                {
                  // if the number of results returned was one, that means that $currentUser is following $followUserName

                  $query =  "DELETE FROM sem_pro_followers WHERE userID = '$currentUserID' AND followingID = '$followUserID'";
                  $results = mysqli_query($dbc, $query);

                  // Display the thing!
                  echo "
                  <div class='container-fluid'>
                    <div class='alert alert-success'>
                      <strong>Success!</strong>
                      <p>First user no longer follows second user!</p>
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
                      <strong>Wait a second... I don't know you...</strong>
                      <p>First user doesn't follow second user yet!</p>
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