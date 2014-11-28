<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes : Administrator Add Quote</title>
  </head>
  <body>
    <?php
    require('global.php');

    print "<h1>Quotes : MySQL Admin : Add Quote</h1>";
    $quote = "";
    $author = "";

    if (isset($_POST['submit'])) {
      $STH = $DBH->prepare("INSERT INTO $dbtable (quote, author) VALUES (?, ?)");
      $errors = array();

      if (validateField($_POST['quote']))
        $quote = trim($_POST[ 'quote' ]);    
      else 
        array_push($errors, "Quote field is empty");
      if (validateField($_POST['author']))
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


    
      if (count ($errors) == 0) {
        try {
          $STH->bindParam(1, $quote);
          $STH->bindParam(2, $author);  
          $STH->execute();      
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

    printQuoteForm("mySQL-admin-addQuote.php", $quote, $author);            

    print '<hr />';

  getSingleQuote($DBH, $dbtable);

    
    ?>
  </body>
</html>