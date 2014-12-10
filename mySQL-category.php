
    <?php
    require('global.php');
    require('header.php');
    $errors = array();

    if(! isset($_GET['category'])) {
      array_push($errors, "No category set.");
      $category = "";
    } else {
      $category = strip_tags($_GET['category']);
    }

    if(is_string($category)) { 


      try {


        $STH = $DBH->prepare('SELECT * FROM categories WHERE name=?');
        $STH->execute(array($category));
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH->fetch();
        $categoryID = $row['id'];

        if($categoryID > 0) {
          $VALSTH = $DBH->prepare("SELECT count(id) FROM ' . $dbrelationtable . ' WHERE relationID=? AND relationType='category'");
          $VALSTH->execute( array($categoryID) );
          $rows = $VALSTH->fetch(PDO::FETCH_NUM);

          $category_quotes = $rows[0];  //# of quotes under category
          print $category_quotes. " quotes under category " . $category . "<br />";

          if($category_quotes > 0) {
              $STH = $DBH->prepare("SELECT * FROM $dbrelationtable WHERE relationID=? AND relationType='category'");
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
            //no quotes under category
          }

        } else {
          //category does not exist
        }




      }
      catch(PDOException $e) {
          echo $e->getMessage();
          exit;
      }

       
    } else {
      array_push($errors, "Category is not a valid string");      
    }
    

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     
    require('footer.php');

    ?>
