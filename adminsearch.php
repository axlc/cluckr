<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Admin > Search Tables");
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
        if(!isset($_POST["submit"]))
        {
          include("snippets/adminsearchform.php");
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

          $terms = $_POST['terms'];

          if($_POST['table'] == "clucks")
          {
            echo "
            <div class='container'>
              <p class='lead'>Results for \"clucks\": </p>
              <table class='table'>
                <thead>
                  <tr>
                    <th>cluckID</th>
                    <th>userID</th>
                    <th>cluck</th>
                  </tr>
                </thead>
                <tbody>";
                  $query = "SELECT * FROM sem_pro_clucks WHERE sem_pro_clucks.cluck LIKE '%$terms%';";

                  $results = mysqli_query($dbc, $query);
                  while($row = mysqli_fetch_array($results))
                  {
                    $cluckID = $row['cluckID'];
                    $userID = $row['userID'];
                    $cluck = $row['cluck'];
                    
                    echo "
                      <tr> <!-- Result -->
                        <td>$cluckID</td>
                        <td>$userID</td>
                        <td>$cluck</td>
                      </tr> <!-- End Result -->
                    ";
                  }
            echo    "  
                </tbody> <!-- End tbody -->
              </table> <!-- End Table -->
            </div> <!-- End container -->
            ";
            // close it out
            mysqli_close($dbc);
          }
          else if($_POST['table'] == "followers")
          {
            echo "
            <div class='container'>
              <p class='lead'>Results for \"followers\": </p>
              <table class='table'>
                <thead>
                  <tr>
                    <th>userID</th>
                    <th>followingID</th>
                  </tr>
                </thead>
                <tbody>";
                  $query = "SELECT * FROM sem_pro_followers WHERE sem_pro_followers.userID = '$terms' OR sem_pro_followers.followingID = '$terms';";

                  $results = mysqli_query($dbc, $query);
                  while($row = mysqli_fetch_array($results))
                  {
                    $userID = $row['userID'];
                    $followingID = $row['followingID'];
                    
                    echo "
                      <tr> <!-- Result -->
                        <td>$userID</td>
                        <td>$followingID</td>
                      </tr> <!-- End Result -->
                    ";
                  }
            echo    "  
                </tbody> <!-- End tbody -->
              </table> <!-- End Table -->
            </div> <!-- End container -->
            ";
            // close it out
            mysqli_close($dbc);
          }
          else if($_POST['table'] == "users")
          {
            echo "
            <div class='container'>
              <p class='lead'>Results for \"users\": </p>
              <table class='table'>
                <thead>
                  <tr>
                    <th>userID</th>
                    <th>userName</th>
                    <th>userEmail</th>
                    <th>userAvatarPath</th>
                    <th>plevel</th>
                  </tr>
                </thead>
                <tbody>";
                  $query = "SELECT * FROM sem_pro_users WHERE sem_pro_users.userName LIKE '%$terms%' OR sem_pro_users.userEmail LIKE '%$terms%';";
                  
                  $results = mysqli_query($dbc, $query);
                  while($row = mysqli_fetch_array($results))
                  {
                    $userID = $row['userID'];
                    $userName = $row['userName'];
                    $userEmail = $row['userEmail'];
                    // uh, we're gonna leave the password out, but adding it here would be trivial if you wanted it.
                    // $password = $row['password'];
                    $userAvatarPath = $row['userAvatarPath'];
                    $plevel = $row['plevel'];
                    
                    echo "
                      <tr> <!-- Result -->
                        <td>$userID</td>
                        <td>$userName</td>
                        <td>$userEmail</td>
                        <td>$userAvatarPath</td>
                        <td>$plevel</td>
                      </tr> <!-- End Result -->
                    ";
                  }
            echo    "  
                </tbody> <!-- End tbody -->
              </table> <!-- End Table -->
            </div> <!-- End container -->
            ";
            // close it out
            mysqli_close($dbc);
          }
          else 
          {
            // close it out
            mysqli_close($dbc);
            echo "<h1>INVALID TABLE NAME. USE THE FORM LUKE.</h1>";
          }
        }
      }
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