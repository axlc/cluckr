<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Search");
  ?>
</head>
<body>

  <?php 
    include("snippets/nav.php");
  ?>

  <main>
    <?php 
      if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])
      {
        $host = "localhost";
        $user = "dbuser";
        $pass = "dbpass";
        $dbname = "dbname";
        $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
                 or die("Error connecting to MariaDB. Error: " 
                 . mysqli_error($dbc));
        
        mysqli_select_db($dbc, $dbname);

        $userIDInput = $_SESSION['userID'];
        $userID = mysqli_real_escape_string($dbc, $userIDInput);

        if(!isset($_POST["submit"]))
        {
          include("snippets/searchform.php");
        }
        else 
        {
          if($_POST['searchType'] == "userName")
          {
            $term = $_POST['terms'];
            echo "
              <p class='lead'>Search Results for \"$term\": </p>
              <div class='container well well-lg'>
                <div class='row'>
                  <div class='col-lg-12 col-md-12'>
                    <div class='row'> 
                    ";

                      $term = mysqli_real_escape_string($dbc, $term);

                      $query = "SELECT sp_users.userAvatarPath, sp_users.userName 
                                FROM sem_pro_users AS sp_users 
                                WHERE sp_users.userName LIKE '%" . $term . "%'
                                ";

                      $results = mysqli_query($dbc, $query);
                      while($row = mysqli_fetch_array($results))
                      {
                        $avatarPath = $row['userAvatarPath'];
                        $userName = $row['userName'];
                        echo "
                          <div class='col-lg-2 col-md-2'> <!-- Result -->
                            <a href='//cis2.actx.edu/~amccracken/semesterproject/user/" . $userName . "'>
                              <img src='" . $avatarPath . "' alt='" . $userName . "-Avatar' class='img img-responsive'>
                            </a>
                            <a href='//cis2.actx.edu/~amccracken/semesterproject/user/" . $userName . "'>". $userName . "</a>
                          </div> <!-- End Result -->
                        ";
                      }

            echo    "  
                    </div> <!-- End Row -->
                  </div> <!-- End col-lg-12 -->
                </div> <!-- End Row -->
              </div> <!-- End container -->
            ";
          }
          else
          {
            $term = $_POST['terms'];
            $term = mysqli_real_escape_string($dbc, $term);
            $query = "SELECT clucks.cluck, sp_users.userName, sp_users.userAvatarPath
                      FROM sem_pro_clucks clucks
                      LEFT JOIN sem_pro_users sp_users ON clucks.userID = sp_users.userID
                      WHERE clucks.cluck LIKE '%" . $term . "%'
                      ORDER BY cluckID DESC
                      LIMIT 25
                      ";
            $results = mysqli_query($dbc, $query);

            echo "
              <div class='container'>
                <div class='row'>
                  <div class='col-lg-10 col-lg-offset-1'>
                  <p class='lead'>Search Results for \"$term\": </p>
            ";
            $i = 0;
            while($row = mysqli_fetch_array($results))
            {
                $cluck    = $row['cluck'];
                $userName = $row['userName'];
                $userAvatarPath = $row['userAvatarPath'];

                $cluckClass = $i % 2 == 0 ? "bg-gray clearfix" : "bg-gray-alternate clearfix";

                echo "
                <div class='$cluckClass'>
                  <div class='cluck'>
                    <div class='col-lg-1 col-md-1 hidden-xs'>
                      <a href='//cis2.actx.edu/~amccracken/semesterproject/user/$userName/'><img src='$userAvatarPath' class='img-circle avatar'></a>
                    </div>
                    <div class='col-lg-11 col-md-11'>
                      <h6></h6>
                      <a href='//cis2.actx.edu/~amccracken/semesterproject/user/$userName/'><em>$userName</em></a>
                      <p class='cluck-text'>$cluck</p>
                    </div>
                  </div>
                </div>
                ";
                $i++;
            }
                echo "
                  </div>
                </div>
              </div>";
          }
        }

        // close it out
        mysqli_close($dbc);
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