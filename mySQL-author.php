
    <?php
    require('global.php');
    require('header.php');
    $errors = array();

    if(! isset($_GET['author'])) {
      array_push($errors, "No author set.");
      $author = "";
    } else {
      $author = strip_tags($_GET['author']);
    }

    if(is_string($author)) { 
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE author=?');
      $VALSTH->execute( array($author) );
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
        //check to see if quote already exists?

      if($rows[0] > 0) {
        try {
          $STH = $DBH->prepare('SELECT * FROM ' . $dbtable . ' WHERE author=?');
          $STH->bindParam(1, $author);
          $STH->execute();     

          $STH->setFetchMode(PDO::FETCH_ASSOC);
          

          //print # of quotes and loop print each one

        while($row = $STH->fetch()) {
          if(is_string($row['quote']))
             print $row['quote'] . "<br />";      
         }

        }
        catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
      } else {
        array_push($errors, "Author " . $author . " does not have any quotes.");        
      }      
    } else {
      array_push($errors, "Author is not a valid string");      
    }
    

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     
    require('footer.php');

    ?>
