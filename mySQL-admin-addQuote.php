    <?php
    $title = "Inspiring Quotes : Administrator Add Quote";

    require('global.php');
    require('header.php');


    print "<h1>Quotes : MySQL Admin : Add Quote</h1>";
    $quote = "";
    $author = "";

    if(isset($_POST['submit'])) {
      $STH = $DBH->prepare("INSERT INTO $dbtable (quote, author) VALUES (?, ?)");
      $errors = array();


      if(isset($_POST['category']) AND validateField($_POST['category']))
        $category = trim($_POST['category']);
      else
        $category = null;
      
      if(validateField($_POST['quote']))
        $quote = trim($_POST[ 'quote' ]);    
      else 
        array_push($errors, "Quote field is empty");
      if(validateField($_POST['author']))
        $author = trim($_POST[ 'author' ]);    
      else 
        array_push($errors, "Author field is empty");
      
        //check to see if quote already exists?
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE quote=?');
      $VALSTH->execute(array($quote));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if($rows[0] > 0) {
        array_push($errors, "Quote already exists in database.");
      }


    
      if(count ($errors) == 0) {
        try {
          $STH->bindParam(1, $quote);
          $STH->bindParam(2, $author);  
          $STH->execute();
          $quoteID = $DBH->lastInsertId();            //how to find last insert ID

          $STH = $DBH->prepare('SELECT * FROM categories WHERE name=?');  //fetch category ID based on name
          $STH->execute(array($category));      
          $STH->setFetchMode(PDO::FETCH_ASSOC);
          $row = $STH->fetch();  
          $relationID = $row['id'];                        
          if(! $relationID > 0) 
            $relationID = 1;
          $STH = $DBH->prepare("INSERT INTO $dbrelationtable (quoteID, relationID, relationType) VALUES (?, ?, 'category')");
          $STH->bindParam(1, $quoteID);
          $STH->bindParam(2, $relationID);  
          //$STH->bindParam(3, "category");  
          $STH->execute();                

          if(isset($_POST['tags']))
            foreach($_POST['tags'] as $tag) {
              $STH = $DBH->prepare('SELECT * FROM tags WHERE name=?');
              $STH->execute(array($tag));      
              $STH->setFetchMode(PDO::FETCH_ASSOC);
              $row = $STH->fetch();  
              $relationID = $row['id'];
              if($relationID > 0) {
                $STH = $DBH->prepare("INSERT INTO $dbrelationtable (quoteID, relationID, relationType) VALUES (?, ?, 'tag')");
                $STH->bindParam(1, $quoteID);            
                $STH->bindParam(2, $relationID);  
                //$STH->bindParam(3, "tag");  
                $STH->execute();      
              }
            }

          print "<h3>Quote: \"" . $quote . "\" by author " . $author . " added!</h3>";      
          $author = $quote = "";
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
      } else {
        foreach ($errors as $error) 
          print "<h3>" . $error . "</h3>";
      }

      print "<hr />";
    } 

    printQuoteForm("mySQL-admin-addQuote.php", $quote, $author, $DBH);            

    print '<hr />';

  getSingleQuote($DBH, $dbtable);

  require('footer.php');    
    ?>
