    <?php    
    require('global.php');
    require('header.php');

    $errors = array();

    print "<h1>Quotes : MySQL Admin : Edit Quote</h1>";

    $id = $_GET['id'];





    
    


    if(!is_numeric($id)) {  //check to make sure it's a valid number
      array_push($errors, "ID is not a valid number");      
    } else {
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE id=?');   //check to make sure this quote ID exists
      $VALSTH->execute(array($id));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if(!$rows[0] > 0) {
        array_push($errors, "Quote ID " . $id . " does not exist");
      } else {


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

          try {
            $STH->bindParam(1, $quote);
            $STH->bindParam(2, $author);
            $STH->bindParam(3, $id);          
            $STH->execute();      
            print "<h3>Quote: \"" . $quote . "\" by author " . $author . " updated!</h3>";      
          }
          catch(PDOException $e) {
            echo $e->getMessage();
          }
        }

        //get quote ID and print out form


        $STH = $DBH->prepare('SELECT quote, author FROM ' . $dbtable . ' WHERE id=?');
        $STH->execute(array($id));
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH->fetch();
        $quote = $row['quote'];
        $author = $row['author'];
        printQuoteForm("mySQL-admin-edit.php?id=" . $id, $quote, $author);            

       }           
    }  

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     



    print '<hr />';

  getSingleQuote($DBH, $dbtable);

  require('footer.php'); 
    ?>
