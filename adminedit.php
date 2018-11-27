<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Admin > Edit Records");
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
        if(!isset($_POST["adminEdit"]))
        {
          include("snippets/admineditform.php");
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

          if($_POST['adminEdit'] == "editUser")
          {
            $userNameInput       = mysqli_escape_string($dbc, $_POST['userName']);
            
            $userEmailInput      = mysqli_escape_string($dbc, $_POST['userEmail']);
            $userPasswordInput   = mysqli_escape_string($dbc, $_POST['password']);
            $plevel              = mysqli_escape_string($dbc, $_POST['plevel']);

            $query = "SELECT * FROM sem_pro_users WHERE userName = '$userNameInput';";

            $results = mysqli_query($dbc, $query);
            if (mysqli_num_rows($results) == 1) 
            {
              $row = mysqli_fetch_array($results);
              $userID = $row['userID'];

              $updateDetailsArray = Array();
              if($userEmailInput != "")
              {
                $updateDetailsArray["userEmail"] = $userEmailInput;
              }
              if($userPasswordInput != "")
              {
                $updateDetailsArray["password"]=$userPasswordInput;
              }
              if($plevel != "")
              {
                $updateDetailsArray["plevel"]=$plevel;
              }

              $updateDetailSize = count($updateDetailsArray);

              $query = "";
              if($updateDetailSize > 0 && $updateDetailSize < 4)
              {
                $query = "UPDATE sem_pro_users SET";
                foreach($updateDetailsArray as $column => $value)
                {
                  $query .= " $column = '$value'";
                  
                  if($updateDetailSize != 1)
                  {
                    $query .= ",";
                  }
                  $updateDetailSize--;
                }
                $query .= " WHERE userID = $userID;";

                // update the users data 
                $results = mysqli_query($dbc, $query);

                // Display the thing!
                echo "
                <div class='container-fluid'>
                  <div class='alert alert-success'>
                    <strong>Success!</strong>
                    <p>User Updated</p>
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
                  <div class='alert alert-success'>
                    <strong>FAILURE!</strong>
                    <p>Come on guy, you gotta submit something besides a username!</p>
                  </div>
                </div>
                ";

                // close it out
                mysqli_close($dbc);
              }
            }
          }
          else if($_POST['adminEdit'] == "editCluck")
          {
            $cluckID = mysqli_escape_string($dbc, $_POST['cluckID']);
            $cluck   = mysqli_escape_string($dbc, $_POST['cluckText']);
            
            $query = "UPDATE sem_pro_clucks SET cluck='$cluck' WHERE cluckID='$cluckID';";
            $results = mysqli_query($dbc, $query);

            // Display the thing!
            echo "
            <div class='container-fluid'>
              <div class='alert alert-success'>
                <strong>Success!</strong>
                <p>Clucking Edited!</p>
              </div>
            </div>
            ";

            // close it out
            mysqli_close($dbc);
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