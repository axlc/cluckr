<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("User Home");
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
          include("snippets/cluckform.php");
        }
        else 
        {
          $cluckText = mysqli_real_escape_string($dbc, strip_tags($_POST['cluck']));

          $query = "INSERT INTO sem_pro_clucks(userID, cluck) VALUES('" . $userID . "', '" . $cluckText . "');";
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
        }

        $query = "SELECT clucks.cluck, sp_users.userName, sp_users.userAvatarPath 
                  FROM ( 
                    SELECT followers.followingID 
                    FROM sem_pro_followers AS followers 
                    WHERE followers.userID = $userID
                  ) sub
                  LEFT JOIN sem_pro_clucks AS clucks 
                    ON sub.followingID = clucks.userID 
                  LEFT JOIN sem_pro_users AS sp_users 
                    ON clucks.userID = sp_users.userID
                  WHERE cluckID IS NOT NULL 
                  ORDER BY cluckID DESC
                  LIMIT 25
                  ";

        $results = mysqli_query($dbc, $query);

        echo "
        <main>
          <div class='container'>
            <div class='row'>
              <div class='col-lg-10 col-lg-offset-1'>
              <p class='lead'>Latest Clucks from those you follow: </p>
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