<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes v1</title>
  </head>
  <body>
    <?php
    
    $dbname = "quotesapp";
    $dbuser = "root";
    $dbpass = "harvard";
    try {
      # MySQL with PDO_MYSQL
      $DBH = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass);
      $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }

    $STH = $DBH->query('SELECT quote, author from quotes');
    $STH->setFetchMode(PDO::FETCH_ASSOC);

    while($row = $STH->fetch()) {
      if(is_string($row['quote']) AND is_string($row['author']))
         print $row['quote'] . " - " . $row['author'] . "<br />";      
    }

//$quote = iconv("UTF-8", "ISO-8859-1", $quote);
    

    ?>
  </body>
</html>