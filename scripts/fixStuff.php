<?php 
      // get ready to generate user profile
		$uname = "asdf";

      $userContent = file_get_contents("../user/$uname/index.php");
      
      // personalize it
      $userContent = strtr($userContent, array("XXXX_UNAME_XXXX" => "$uname"));

      echo $userContent;

      // create it on the filesystem
      file_put_contents("../user/$uname/index.php", $userContent)
        or die("Failed to generate user profile. Please contact an administrator to continue.");

        $mode = 777;
        chmod("../user/$uname", octdec($mode));
        chmod("../user/$uname/index.php", octdec($mode));

 ?>