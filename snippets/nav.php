<?php 
  $timeoutLength = 1800;
  if(!isset($_SESSION))
  {
    session_start();
  }
  if(isset($_SESSION['loggedIn']) && time() - $_SESSION['timeout'] > $timeoutLength)
  {
    session_unset();
    session_destroy();
    header("Location: http://cis2.actx.edu/~amccracken/semesterproject/login.php?loginstatus=timeout");
    $_SESSION = [];
    exit();
  }
  if(isset($_SESSION['plevel']))
  {
    $_SESSION['timeout'] = time();

    $plevel = $_SESSION['plevel'];
    if($plevel == 99)
    {
      echo "
      <nav class='navbar navbar-inverse'>
        <div class='container-fluid'>
          <div class='navbar-header'>
            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavBar'>
              <span class='icon-bar'></span>
              <span class='icon-bar'></span>
              <span class='icon-bar'></span>
            </button>
            <a href='//cis2.actx.edu/~amccracken/semesterproject' class='navbar-brand clucked-light'>Cluckr!</a>
          </div>
          <div class='collapse navbar-collapse' id='myNavBar'>
            <ul class='nav navbar-nav'>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/userhome.php'>User Home</a></li>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/contact.php'>Contact Us</a></li>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/search.php'>Search</a></li>
              <li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Admin <span class='caret'></span></a>
                <ul class='dropdown-menu'>
                  <li><a href='//cis2.actx.edu/~amccracken/semesterproject/adminadd.php'>Add User/Cluck/Follower</a></li>
                  <li><a href='//cis2.actx.edu/~amccracken/semesterproject/adminremove.php'>Remove User/Cluck/Follower</a></li>
                  <li><a href='//cis2.actx.edu/~amccracken/semesterproject/adminedit.php'>Edit User/Cluck</a></li>
                  <li role='separator' class='divider'></li>
                  <li><a href='//cis2.actx.edu/~amccracken/semesterproject/adminview.php'>View All Tables</a></li>
                  <li><a href='//cis2.actx.edu/~amccracken/semesterproject/adminsearch.php'>Search All Tables</a></li>
                </ul>
              </li>
            </ul> 
            <ul class='nav navbar-nav navbar-right'>
              <li><input type='submit' class='btn btn-primary navbar-btn' onclick=\"document.getElementById('logout').click();\" value='Logout'></li>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/user/" . $_SESSION['userName'] . "/'><span class='glyphicon glyphicon-user clucked-light'></span> Profile</a></li>
            </ul>
          </div>
        </div>
      </nav>
      <form style='display:none' action='//cis2.actx.edu/~amccracken/semesterproject/scripts/logoutscript.php' method='POST'><input type='submit' id='logout' name='logout'></form>
      ";
    }
    else
    { 
      echo "
      <nav class='navbar navbar-inverse'>
        <div class='container-fluid'>
          <div class='navbar-header'>
            <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavBar'>
              <span class='icon-bar'></span>
              <span class='icon-bar'></span>
              <span class='icon-bar'></span>
            </button>
            <a href='//cis2.actx.edu/~amccracken/semesterproject' class='navbar-brand clucked-light'>Cluckr!</a>
          </div>
          <div class='collapse navbar-collapse' id='myNavBar'>
            <ul class='nav navbar-nav'>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/userhome.php'>User Home</a></li>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/contact.php'>Contact Us</a></li>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/search.php'>Search</a></li>
            </ul> 
            <ul class='nav navbar-nav navbar-right'>
              <li><input type='submit' class='btn btn-primary navbar-btn' onclick=\"document.getElementById('logout').click();\" name='logout' 
              value='Logout'></li>
              <li><a href='//cis2.actx.edu/~amccracken/semesterproject/user/" . $_SESSION['userName'] . "/'><span class='glyphicon glyphicon-user clucked-light'></span> Profile</a></li>
            </ul>
          </div>
        </div>
      </nav>
      <form style='display:none' action='//cis2.actx.edu/~amccracken/semesterproject/scripts/logoutscript.php' method='POST'><input type='submit' id='logout' name='logout'></form>
      ";
    }
  }
  else
  {
    echo "
    <nav class='navbar navbar-inverse'>
      <div class='container-fluid'>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavBar'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a href='//cis2.actx.edu/~amccracken/semesterproject/' class='navbar-brand clucked-light'>Cluckr!</a>
        </div>
        <div class='collapse navbar-collapse' id='myNavBar'>
          <ul class='nav navbar-nav'>
            <li><a href='//cis2.actx.edu/~amccracken/semesterproject/index.php'>Home</a></li>
            <li><a href='//cis2.actx.edu/~amccracken/semesterproject/contact.php'>Contact Us</a></li>
          </ul> 
          <ul class='nav navbar-nav navbar-right'>
            <li><a href='//cis2.actx.edu/~amccracken/semesterproject/login.php'><span class='glyphicon glyphicon-log-in clucked-light'></span> Log In</span></a></li>
            <li><a href='//cis2.actx.edu/~amccracken/semesterproject/signup.php'><span class='glyphicon glyphicon-user clucked-light'></span> Sign Up</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    ";
  }
 ?>