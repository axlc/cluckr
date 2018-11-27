<div class="container">
  <div class="row">
    <div class="col-lg-6 col-lg-offset-3 well">
      <form method="post" action="" class="form-horizontal">
        <div class="form-group">                        
          <label for="cluckEntry" class="sr-only control-label">Enter your cluck</label>
          <textarea style="resize:none" id="cluckEntry" name="cluck" placeHolder="Enter your cluck" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <h6 class="pull-left" id="count_message"></h6>
          <button name="submit" value="submit" class="btn btn-primary pull-right">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  var text_max = 140;
  $('#count_message').html(text_max + ' remaining');

  $('#cluckEntry').keyup(function() {
    var text_length = $('#cluckEntry').val().length;
    var text_remaining = text_max - text_length;

    $('#count_message').html(text_remaining + ' remaining');
  });
</script>