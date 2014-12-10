
    <?php
    require('global.php');
    require('header.php');
    $errors = array();

    if(! isset($_GET['id'])) {
      array_push($errors, "ID is not set.");
      $id = "";
    } else {
      $id = $_GET['id'];
    }

    if(is_numeric($id)) { 
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE id=?');
      $VALSTH->execute( array($id) );
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
        //check to see if quote already exists?

      if($rows[0] > 0) {
        try {
          $STH = $DBH->prepare('SELECT * FROM ' . $dbtable . ' WHERE id=?');
          $STH->execute( array($id) );          
          $STH->setFetchMode(PDO::FETCH_ASSOC);
          $row = $STH->fetch();           
          if(is_string($row['quote']) AND is_string($row['author']))
             print $row['quote'] . " - " . $row['author'] . "<br />";      
           print "<hr />";


           //print category
          $STH = $DBH->prepare("SELECT * FROM " . $dbrelationtable . " WHERE quoteid=? AND relationType='category'");
          $STH->execute( array($id) );          
          if($row = $STH->fetch()) {
            $categoryID = $row['relationID'];
            $STH = $DBH->prepare("SELECT * FROM " . $dbcategorytable . " WHERE id=?");
            $STH->execute( array($categoryID) );          
            if($cat_row = $STH->fetch())
              print "Category: " . $cat_row['name'] . "<br />";
          }
          $STH = $DBH->prepare("SELECT * FROM " . $dbrelationtable . " WHERE quoteid=? AND relationType='tag'");
          $STH->execute( array($id) );          
          while($row = $STH->fetch()) {
            $tagID = $row['relationID'];
            $STH = $DBH->prepare("SELECT * FROM " . $dbtagstable . " WHERE id=?");
            $STH->execute( array($tagID) );          
            if($tag_row = $STH->fetch())
              print "Tag: " . $tag_row['name'] . "<br />";
          }


        }
        catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
      } else {
        array_push($errors, "Quote ID " . $id . " does not exist");        
      }      
    } else {
      array_push($errors, "ID is not a valid number");      
    }
    

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     
    require('footer.php');

    ?>
