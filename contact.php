<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    include("snippets/head.php");
    setTitle("Contact");
  ?>
</head>
<body>
  <?php 
    include("snippets/nav.php");
    include("snippets/header.php");
  ?>

  <main>
    <?php 
      if(!isset($_POST["submit"]))
      {
        include("snippets/contactform.php");
      }
      else
      {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        $message = strip_tags($message);
        // Mail the password to the given email address
        $to = "admin@cluckr.com";
        $subject = "[Cluckr] Contact Form Submission from: $fname $lname";
        $message = $message;
        $headers = "From: user@domain.com" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);

        echo "
          <div class='container-fluid'>
            <div class='alert alert-success'>
              <strong>Success!</strong>
              <p>Your message has been sent</p>
            </div>
          </div>
        ";
      }
    ?>
  </main>
  
  <?php 
    include("snippets/footer.php");
  ?>
</body>
</html>