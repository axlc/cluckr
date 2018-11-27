<?php 
  if(!isset($_SESSION))
  {
    session_start();
  }

  if(isset($_SESSION['userID']))
  {
    // User is logged in
    $url = strtok($_SERVER['REQUEST_URI'], '?');

    if($_SESSION['userName'] == "XXXX_UNAME_XXXX")
    {
      echo "
      <script>
        $(function() {
          $('#toggle-follower').bootstrapToggle('destroy');
          $('#toggle-holder').remove();
        })
      </script>
      ";
    }
    if(followCheck($_SESSION['userID'], "XXXX_UNAME_XXXX"))
    {
      echo "
      <script>
        $(function() {
          $('#toggle-follower').bootstrapToggle('on');
        })
      </script>
      ";
    }
    else 
    {
      echo "
      <script>
        $(function() {
          $('#toggle-follower').bootstrapToggle('off');
        })
      </script>
      ";
    }
    echo "
      <input 
        type          = 'checkbox' 
        id            = 'toggle-follower' 
        data-toggle   = 'toggle' 
        data-size     = 'large' 
        data-on       = 'Following' 
        data-off      = 'Not Following' 
        data-onstyle  = 'success' 
        data-offstyle = 'info'>
      
      <script>
        $(function() {
          $('#toggle-follower').change(function() {
            $('#toggleFollow').click();
          })
        })
      </script>

      <form style='display:none' action='//cis2.actx.edu/~amccracken/semesterproject/scripts/followToggle.php' method='POST'>
        <input type='hidden' name='currentUser' value='" . $_SESSION['userID'] . "'>
        <input type='hidden' name='followUser' value='XXXX_UNAME_XXXX'>
        <input type='hidden' name='referrer' value='". $url ."'>
        <input type='submit' id='toggleFollow' name='toggleFollow' value='toggleFollow'>
      </form>
    ";
  }
  else 
  {
    // User is not logged in
    echo "
      <input 
        type          = 'checkbox' 
        id            = 'toggle-follower' 
        data-toggle   = 'toggle' 
        data-size     = 'large' 
        data-on       = 'Following' 
        data-off      = 'Not Following' 
        data-onstyle  = 'success' 
        data-offstyle = 'info'>

      <script>
        $(function() {
          $('#toggle-follower').change(function() {
            $('#alert-holder').html(\"<div class='alert alert-warning' style='padding-bottom: 10px'><strong>Whoa there!&nbsp;</strong>Sign Up in order to follow other users!</div>\");
            $('#toggle-holder').removeClass('col-lg-offset-9 col-md-offset-9');
            $('#toggle-follower').bootstrapToggle('off');
            $('#toggle-follower').bootstrapToggle('disable');
          })
        })
      </script>
    ";
  }

  function followCheck($currentUserID, $followUserName)
  {
    $currentUserInput = $currentUserID;
    $followNameInput = $followUserName;
      
    $host = "localhost";
    $user = "dbuser";
    $pass = "dbpass";
    $dbname = "dbname";

    $dbc   = mysqli_connect("localhost", "dbuser", "dbpass")
             or die("Error connecting to MariaDB. Error: " 
             . mysqli_error($dbc));

    mysqli_select_db($dbc, $dbname);

    $currentUser = mysqli_escape_string($dbc, $currentUserInput);
    $followName = mysqli_escape_string($dbc, $followNameInput);

    $query = "SELECT sem_pro_followers.userID, sem_pro_followers.followingID
              FROM sem_pro_users
              INNER JOIN sem_pro_followers 
              ON (sem_pro_followers.followingID = sem_pro_users.userID)
              WHERE sem_pro_users.userName = '$followName'
              AND sem_pro_followers.userID = '$currentUser'
              LIMIT 1
              ";

    $results = mysqli_query($dbc, $query);

    mysqli_close($dbc);

    return mysqli_num_rows($results);
  }
 ?>