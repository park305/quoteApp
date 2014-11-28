<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes : Administrator Add Quote</title>
  </head>
  <body>
    <?php
    require('global.php');
    $STH = $DBH->prepare("INSERT INTO $dbtable (quote, author) VALUES (?, ?)");
    $errors = array();

    if (isset($_POST[ 'quote' ]) AND is_string($_POST['quote'] AND strlen($_POST['quote']) > 0)) {
      $quote = trim($_POST[ 'quote' ]);    
    } else {
      array_push($errors, "Error with quote field");
    }
    if (isset($_POST[ 'author' ]) AND is_string($_POST['author'] AND strlen($_POST['author']) > 0)) {
      $author = trim($_POST[ 'author' ]);    
    } else {
      array_push($errors, "Error with author field");
    }

    if (count ($errors) == 0) {
      print "Quote: " . $quote . " by " . $author . " added!<br />";      
    } else {
      foreach ($errors as $error) {
        print $error. "<br />";
      }

    }
    /*
if (isset($_POST['Submit'])) {}


    if(is_string($quote) AND is_string($author)) {
      $STH->bindParam(1, $quote);
      $STH->bindParam(2, $author);  
      $STH->execute();  
    }
    */
    print "<h1>Quotes : MySQL Admin : Add Quote</h1>";

    print '
    <form action="mySQL-admin-quoteSubmit.php" method="post">
        <label for="quote">Quote:</label> <textarea id="quote" name="quote">' . $_POST["quote"] . '</textarea> <br />
        <label for="author">Author: </label> <input type="text" id="author" value="' . $_POST["author"] . '" name="author" /><br />
      <input type="submit" />
    </form>
    ';

    print '<hr />';


  getSingleQuote($DBH, $dbtable);


    

    ?>
  </body>
</html>