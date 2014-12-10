    <?php    
    require('global.php');
    require('header.php');

    $errors = array();

    print "<h1>Quotes : MySQL Admin : Edit Quote</h1>";

      $id = $_GET['id'];
    $categoryID = null;
    $quote_tags = array();





    
    


    if(!is_numeric($id)) {  //check to make sure it's a valid number
      array_push($errors, "ID is not a valid number");      
    } else {



      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE id=?');   //check to make sure this quote ID exists
      $VALSTH->execute(array($id));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if(!$rows[0] > 0) {
        array_push($errors, "Quote ID " . $id . " does not exist");
      } else {


        //setting up the category and tags for this quote if this is the edit page that hasn't been submitted yet or submit fails
        $STH = $DBH->prepare("SELECT * FROM $dbrelationtable WHERE quoteID=? AND relationType='category'");  
        $STH->execute(array($id));      
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH->fetch();      
        $categoryID = $row['id'];   

        $STH = $DBH->prepare("SELECT * FROM $dbrelationtable WHERE quoteID=? AND relationType='tag'");  
        $STH->execute(array($id));      
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $STH->fetch())
          array_push($quote_tags, $row['relationID']);      


        if (isset($_POST['submit'])) {    //form submitted updating quote          
          $STH = $DBH->prepare("UPDATE $dbtable SET quote=?, author=? WHERE id=?");

          if (validateField($_POST['quote']))
            $quote = trim($_POST[ 'quote' ]);    
          else 
            array_push($errors, "Quote field is empty");
          if (validateField($_POST['author']))
            $author = trim($_POST[ 'author' ]);    
          else 
            array_push($errors, "Author field is empty");
          if(validateField($_POST['category']))
            $category = trim($_POST['category']);
          else
            array_push($errors, "Missing category");

          if(count ($errors) == 0) {

            try {   
              $STH->bindParam(1, $quote);
              $STH->bindParam(2, $author);
              $STH->bindParam(3, $id);          
              $STH->execute();      //updated quote
              //updating category
              $STH = $DBH->prepare('SELECT * FROM categories WHERE name=?');  //fetch category ID based on name
              $STH->execute(array($category));      
              $STH->setFetchMode(PDO::FETCH_ASSOC);
              $row = $STH->fetch();  
              $relationID = $row['id'];            
              $categoryID = $relationID;   

              $STH = $DBH->prepare("SELECT count(id) FROM " . $dbrelationtable . " WHERE quoteID=? AND relationID=? AND relationType='category'"); 
              $STH->execute(array($id, $relationID));      
              $row = $STH->fetch(PDO::FETCH_NUM);  

              if(!$rows[0] > 0) {
                  //nothing to do this already exists
              } else {
                //update existing category relatoin if it exists
                //
                $STH = $DBH->prepare("SELECT * FROM " . $dbrelationtable . " WHERE quoteID=? AND relationType='category'");  
                $STH->execute(array($id));      
                $STH->setFetchMode(PDO::FETCH_ASSOC);
                $row = $STH->fetch();  
                if($row['id'] > 0) {    //update the category ID # for this quote
                  $STH = $DBH->prepare("UPDATE " . $dbrelationtable . " SET relationID=? WHERE quoteID=?");  
                  $STH->execute(array($relationID, $id));      
                } else {  //insert category ID for this quote
                  $STH = $DBH->prepare("INSERT INTO " . $dbrelationtable . " (quoteID, relationID, relationType) VALUES (?, ?, 'category')");
                  $STH->execute(array($id, $relationID));      
                }
              }
              //finished updating category

              //updating tags
              $quote_tags = array();              
              if(isset($_POST['tags'])) {
                foreach($_POST['tags'] as $tag) {
                  $STH = $DBH->prepare('SELECT * FROM tags WHERE name=?');
                  $STH->execute(array($tag));      
                  $STH->setFetchMode(PDO::FETCH_ASSOC);
                  $row = $STH->fetch();  
                  $relationID = $row['id'];
                  array_push($quote_tags, $relationID);
                  if($relationID > 0) {

                    $STH = $DBH->prepare("SELECT count(id) FROM " .  $dbrelationtable . " WHERE quoteID=? AND relationID=? AND relationType='tag'"); 
                    $STH->execute(array($id, $relationID));      
                    $row = $STH->fetch(PDO::FETCH_NUM);  
                    if(!$rows[0] > 0) {
                    //nothing to do this already exists
                    } else {
                        $STH = $DBH->prepare("INSERT INTO " . $dbrelationtable . " (quoteID, relationID, relationType) VALUES (?, ?, 'tag')");
                        $STH->execute(array($id, $relationID));      
                    }

                 
                  }
                }
              }

              //what to do if the user removed tags though, how am i checking for that?
              if(count($quote_tags) > 0) {
                $placeholders = array_fill(0, count($quote_tags), '?');      
                $STH = $DBH->prepare("DELETE FROM " . $dbrelationtable . " WHERE relationType='tag' AND quoteID=? AND relationID NOT IN (" . implode(',', $placeholders) . ")");               
                $STH->bindParam(1, $id);
                foreach ($quote_tags as $k => $tid)
                  $STH->bindValue(($k+2), $tid);
              } else {
                $STH = $DBH->prepare("DELETE FROM " . $dbrelationtable . " WHERE relationType='tag' AND quoteID=?");               
                $STH->bindParam(1, $id);
              }
              $STH->execute();

            }
            catch(PDOException $e) {
              echo $e->getMessage();
            }
          } //end IF checking errors
        } //end $_POST['submit'] check

        //get quote ID and print out form
        $STH = $DBH->prepare('SELECT quote, author FROM ' . $dbtable . ' WHERE id=?');
        $STH->execute(array($id));
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH->fetch();
        $quote = $row['quote'];
        $author = $row['author'];
        print $quote . " by " . $author . " with ID# ".  $id . "<br />";
        printQuoteForm("mySQL-admin-edit.php?id=" . $id, $quote, $author, $id, $DBH, $categoryID, $quote_tags);            

       }           
    }  

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     



    print '<hr />';

  getSingleQuote($DBH, $dbtable);

  require('footer.php'); 
    ?>
