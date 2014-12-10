
    <?php
    require('global.php');
    require('header.php');
    $errors = array();

    if(! isset($_GET['tag'])) {
      array_push($errors, "No tag set.");
      $tag = "";
    } else {
      $tag = strip_tags($_GET['tag']);
    }

    if(is_string($tag)) { 


      try {


        $STH = $DBH->prepare('SELECT * FROM tags WHERE name=?');
        $STH->execute(array($tag));
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH->fetch();
        $categoryID = $row['id'];

        if($categoryID > 0) {
          $VALSTH = $DBH->prepare("SELECT count(id) FROM ' . $dbrelationtable . ' WHERE relationID=? AND relationType='tag'");
          $VALSTH->execute( array($categoryID) );
          $rows = $VALSTH->fetch(PDO::FETCH_NUM);

          $category_quotes = $rows[0];  //# of quotes under tag
          print $category_quotes. " quotes under tag " . $tag . "<br />";

          if($category_quotes > 0) {
              $STH = $DBH->prepare("SELECT * FROM $dbrelationtable WHERE relationID=? AND relationType='tag'");
              $STH->execute(array($categoryID));
              $STH->setFetchMode(PDO::FETCH_ASSOC);
              while($row = $STH->fetch()) {
                $quoteID = $row['quoteID'];
                $STH = $DBH->prepare("SELECT * FROM $dbtable WHERE id=?");
                $STH->execute(array($quoteID));
                $STH->setFetchMode(PDO::FETCH_ASSOC);              
                print $row['quote'] . "<br />";                    
              }

          } else {
            //no quotes under tag
          }

        } else {
          //tag does not exist
        }




      }
      catch(PDOException $e) {
          echo $e->getMessage();
          exit;
      }


    } else {
      array_push($errors, "Tag is not a valid string");      
    }
    

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     
    require('footer.php');

    ?>
