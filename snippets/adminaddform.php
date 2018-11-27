<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3 well">
      <p class='lead'>Add to Users</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="userName" class="sr-only control-label">userName</label>
          <input type="text" id="userName" name="userName" placeHolder="userName" class="form-control" maxlength="255" required>
        </div>
        <div class="form-group">
          <label for="userEmail" class="sr-only control-label">userEmail</label>
          <input type="text" id="userEmail" name="userEmail" placeHolder="userEmail" class="form-control" maxlength="255" required>
        </div>
        <div class="form-group">
          <label for="password" class="sr-only control-label">password</label>
          <input type="text" id="password" name="password" placeHolder="password" class="form-control" maxlength="30" required>
        </div>
        <div class="form-group">
          <label for="plevel" class="sr-only control-label">plevel (1 for normal, 99 for admin</label>
          <input type="text" id="plevel" name="plevel" placeHolder="plevel (1 for normal, 99 for admin" class="form-control" maxlength="2" required>
        </div>
        <div class="form-group">
          <button name="adminAdd" value="addUser" class="btn btn-primary btn-block">Submit</button>
        </div>
      </form>
      <div class='clearfix'>&nbsp;</div>
      <p class='lead'>Add to Clucks</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="userName" class="sr-only control-label">userName</label>
          <input type="text" id="userName" name="userName" placeHolder="userName" class="form-control" maxlength="25" required>
        </div>
        <div class="form-group">
          <label for="cluck" class="sr-only control-label">cluck</label>
          <input type="text" id="cluck" name="cluck" placeHolder="cluck" class="form-control" maxlength="140" required>
        </div>
        <div class="form-group">
          <button name="adminAdd" value="addCluck" class="btn btn-primary btn-block">Submit</button>
        </div>
      </form>
      <div class='clearfix'>&nbsp;</div>
      <p class='lead'>Add to Followers</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="userName" class="sr-only control-label">userName</label>
          <input type="text" id="userName" name="userName" placeHolder="userName" class="form-control" maxlength="255" required>
        </div>
        <div class="form-group">
          <label for="followingName" class="sr-only control-label">followingName</label>
          <input type="text" id="followingName" name="followingName" placeHolder="followingName" class="form-control" maxlength="255" required>
        </div>
        <div class="form-group">
          <button name="adminAdd" value="addFollowers" class="btn btn-primary btn-block">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>