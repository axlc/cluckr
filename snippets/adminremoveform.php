<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3 well">
      <p class='lead'>Remove From Users</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="userName" class="sr-only control-label">userName</label>
          <input type="text" id="userName" name="userName" placeHolder="userName" class="form-control" maxlength="255" required>
        </div>
        <div class="form-group">
          <button name="adminRemove" value="removeUser" class="btn btn-danger btn-block">Submit</button>
        </div>
      </form>
      <div class='clearfix'>&nbsp;</div>
      <p class='lead'>Remove From Clucks</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="cluckID" class="sr-only control-label">cluckID</label>
          <input type="text" id="cluckID" name="cluckID" placeHolder="cluckID" class="form-control" maxlength="25" required>
        </div>
        <div class="form-group">
          <button name="adminRemove" value="removeCluck" class="btn btn-danger btn-block">Submit</button>
        </div>
      </form>
      <div class='clearfix'>&nbsp;</div>
      <p class='lead'>Remove From Followers</p>
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
          <button name="adminRemove" value="removeFollowers" class="btn btn-danger btn-block">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>