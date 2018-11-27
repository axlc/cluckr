<?php 
  $dbc = mysqli_connect("localhost", "dbuser", "dbpass");

  mysqli_select_db($dbc, "amccracken");

  $query = "CREATE TABLE IF NOT EXISTS sem_pro_users(
            userID         INT UNSIGNED NOT NULL AUTO_INCREMENT,
            userName       VARCHAR(255) NOT NULL,
            userEmail      VARCHAR(255) NOT NULL,
            password       VARCHAR(30)  NOT NULL,
            userAvatarPath VARCHAR(255) NOT NULL DEFAULT '//cis2.actx.edu/~amccracken/semesterproject/img/default.jpg',
            plevel         INT UNSIGNED NOT NULL DEFAULT '1',
            PRIMARY KEY (userID));
            ";

  $results = mysqli_query($dbc, $query);

  $query = "CREATE TABLE IF NOT EXISTS sem_pro_clucks(
            cluckID    INT UNSIGNED NOT NULL AUTO_INCREMENT,
            userID     INT UNSIGNED NOT NULL,
            cluck      VARCHAR(140) NOT NULL,
            PRIMARY KEY (cluckID),
            FOREIGN KEY userID(userID) REFERENCES sem_pro_users(userID) ON UPDATE CASCADE ON DELETE CASCADE);
            ";

  $results = mysqli_query($dbc, $query);

  $query = "CREATE TABLE IF NOT EXISTS sem_pro_followers(
            userID      INT UNSIGNED NOT NULL REFERENCES sem_pro_users (userID),
            followingID INT UNSIGNED NOT NULL REFERENCES sem_pro_users (userID),
            PRIMARY KEY (userID, followingID),
            FOREIGN KEY userID(userID)           REFERENCES sem_pro_users(userID) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY followingID(followingID) REFERENCES sem_pro_users(userID) ON UPDATE CASCADE ON DELETE CASCADE);
            ";

  $results = mysqli_query($dbc, $query);
  
  echo "Tables and relationships Created";

  mysqli_close($dbc);
?>