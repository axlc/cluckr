<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3 well">
      <p class='lead'>Edit Users (leave blank to keep the same)</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="userName" class="sr-only control-label">userName</label>
          <input type="text" id="userName" name="userName" placeHolder="userName" class="form-control" maxlength="255" required>
        </div>
        <div class="form-group">
          <label for="userEmail" class="sr-only control-label">userEmail</label>
          <input type="text" id="userEmail" name="userEmail" placeHolder="userEmail" class="form-control" maxlength="255">
        </div>
        <div class="form-group">
          <label for="password" class="sr-only control-label">password</label>
          <input type="text" id="password" name="password" placeHolder="password" class="form-control" maxlength="30">
        </div>
        <div class="form-group">
          <label for="plevel" class="sr-only control-label">plevel (1 for normal, 99 for admin</label>
          <input type="text" id="plevel" name="plevel" placeHolder="plevel (1 for normal, 99 for admin" class="form-control" maxlength="2">
        </div>
        <div class="form-group">
          <button name="adminEdit" value="editUser" class="btn btn-primary btn-block">Edit User</button>
        </div>
      </form>
      <div class='clearfix'>&nbsp;</div>
      <p class='lead'>Edit Clucks</p>
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="cluckID" class="sr-only control-label">cluckID</label>
          <input type="text" id="cluckID" name="cluckID" placeHolder="cluckID" class="form-control" maxlength="25" required>
        </div>
        <div class="form-group">
          <label for="cluckText" class="sr-only control-label">cluckText</label>
          <input type="text" id="cluckText" name="cluckText" placeHolder="cluckText" class="form-control" maxlength="140" required>
        </div>
        <div class="form-group">
          <button name="adminEdit" value="editCluck" class="btn btn-primary btn-block">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>