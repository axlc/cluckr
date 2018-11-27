<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3 well">
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="fname" class="sr-only control-label">Search Terms:</label>
          <input type="text" id="terms" name="terms" placeHolder="Search Terms:" class="form-control" maxlength="25" required>
        </div>
        <div class="form-group">
          <label class="radio-inline"><input type="radio" name="table" value="clucks">Search clucks</label>
          <label class="radio-inline"><input type="radio" name="table" value="followers">Search followers</label>
          <label class="radio-inline"><input type="radio" name="table" value="users">Search users</label>
        </div>
        <div class="form-group">
          <button name="submit" value="submit" class="btn btn-primary btn-block">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>