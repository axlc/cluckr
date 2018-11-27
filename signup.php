<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Sign Up");
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
        <div class="col-lg-6 text-center">
          <span class="glyphicon glyphicon-grain logo"></span>
        </div>
        <div class="col-lg-6">
          <form method="post" role="form" action="scripts/signupscript.php" class="form-horizontal" data-toggle="validator">
            <div class="form-group">
              <label for="userName" class="sr-only control-label">Enter your user name: </label>
              <input type="text" id="userName" name="userName" placeholder="Enter your user name: " class="form-control" data-remote="scripts/userNameCheck.php" required>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label for="userEmail" class="sr-only control-label">Enter your email address: </label>
              <input type="email" id="userEmail" name="userEmail" placeholder="Enter your email address: " class="form-control" data-remote="scripts/emailCheck.php" required>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label for="userEmail" class="sr-only control-label">Enter your password: </label>
              <input type="password" id="userPass1" name="userPass1" data-minlength= "8" placeholder="Enter your password:" class="form-control" required>
              <div class="help-block">Minimum of 8 characters</div>
            </div>
            <div class="form-group">
              <label for="userEmail" class="sr-only control-label">Verify your password: </label>
              <input type="password" id="userPass2" name="userPass2" data-minlength= "8" placeholder="Verify your password:" class="form-control" data-match="#userPass1" data-match-error="Wait a sec, these don't match. Try again." required>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <input type="submit" name="submit" value="Signup" class="btn btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  <?php 
    include("snippets/footer.php");
    echo "<script src='js/validator.js'></script>";
  ?>
</body>
</html>