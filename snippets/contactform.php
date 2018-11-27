<div class="container">
  <div class="row">
    <div class="col-lg-6 text-center">
      <span class="glyphicon glyphicon-grain logo"></span>
    </div>
    <div class="col-lg-6">
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">
          <label for="fname" class="sr-only control-label">Enter your first name</label>
          <input type="text" id="fname" name="fname" placeHolder="Enter your first name:" class="form-control" maxlength="25" required>
        </div>
        <div class="form-group">
          <label for="lname" class="sr-only control-label">Enter your last name</label>
          <input type="text" id="lname" name="lname" placeHolder="Enter your last name:" class="form-control" maxlength="25" required>
        </div>
        <div class="form-group">                        
          <label for="email" class="sr-only control-label">Enter your email address</label>
          <input type="email" id="email" name="email" placeHolder="Enter your email address:" class="form-control" maxlength="50" required>
        </div>
        <div class="form-group">                        
          <label for="message" class="sr-only control-label">Enter your message</label>
          <textarea id="message" name="message" placeHolder="Enter your message:" class="form-control" rows="8" required></textarea>
        </div>
        <div class="form-group">
          <button name="submit" value="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>