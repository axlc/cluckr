<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include(dirname(__FILE__, 3) . "/snippets/head.php");
    setTitle("jack");
  ?>
</head>
<body>

  <?php 
    include(dirname(__FILE__, 3) . "/snippets/nav.php");
  ?>

  <?php 
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $query = "SELECT clucks.cluck, sp_users.userName, sp_users.userAvatarPath
              FROM sem_pro_clucks clucks
              LEFT JOIN sem_pro_users sp_users ON clucks.userID = sp_users.userID
              WHERE sp_users.userName='jack'
              ORDER BY cluckID DESC
              LIMIT 25";

    $results = mysqli_query($dbc, $query);

    // close it out
    mysqli_close($dbc);

    echo "
    <main>
      <div class='container'>
        <div class='row'>
          <div class='col-lg-8 col-md-8 col-lg-offset-1 col-md-offset-1' id='alert-holder'>
          </div>
          <div id='toggle-holder' class='col-lg-2 col-md-2 col-lg-offset-9 col-md-offset-9' style='padding-bottom: 21px;'>";
            // including the follow toggle
            include("followToggle.php");
    echo "</div>
        </div>
        <div class='row'>
          <div class='col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1'>
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
      </div>
    </main>
    ";
    include(dirname(__FILE__, 3) . "/snippets/footer.php");
  ?>

</body>
</html>