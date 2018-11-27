<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Log In");
  ?>
</head>
<body>
  
  <?php 
    include("snippets/nav.php");
    include("snippets/header.php");
  ?>

  <main>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
        <?php 
          if(isset($_REQUEST['loginstatus']))
          {
            if($_REQUEST['loginstatus'] == "fail")
            {
              echo "<div role='alert' class='alert alert-danger'><strong>Login Failure: </strong>Check that username and password!</div>";
            }
            else if($_REQUEST['loginstatus'] == "ua")
            {
              echo "<div role='alert' class='alert alert-warning'><strong>Unauthorized Access: </strong>You need to log in better than that!</div>";
            }
            else if($_REQUEST['loginstatus'] == "timeout")
            {
              echo "<div role='alert' class='alert alert-info'><strong>Timeout: </strong>You don't have to go to the corner or anything, but you were inactive too long.</div>";
            }
            else if($_REQUEST['loginstatus'] == "logout")
            {
              echo "<div role='alert' class='alert alert-success'><strong>Logged Out: </strong>You've successfully logged out. Yay.</div>";
            }
          }
        ?>
          <form method="post" role="form" action="scripts/loginscript.php" class="form-horizontal" data-toggle="validator">
            <div class="form-group">
              <label for="userName" class="sr-only control-label">Enter your username: </label>
              <input type="text" id="userName" name="userName" placeholder="Enter your username:" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="userEmail" class="sr-only control-label">Enter your password: </label>
              <input type="password" id="userPass" name="userPass" placeholder="Enter your password:" class="form-control" required>
            </div>
            <div class="form-group">
              <input type="submit" name="submit" value="Log In" class="btn btn-primary">
            </div>
          </form>
        </div>
        <div class="col-lg-6 text-center">
          <span class="glyphicon glyphicon-grain logo"></span>
        </div>
      </div>
    </div>
  </main>
  
  <?php 
    include("snippets/footer.php");
  ?>
</body>
</html>