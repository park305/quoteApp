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


  $STH = $DBH->query('SELECT quote, author FROM quotes AS quotetbl JOIN
    (SELECT (RAND() * (SELECT MAX(id) FROM quotes)) AS id) AS r2
    WHERE quotetbl.id >= r2.id
    ORDER BY quotetbl.id ASC LIMIT 1');
    //http://jan.kneschke.de/projects/mysql/order-by-rand/
  
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $row = $STH->fetch();
    if(is_string($row['quote']) AND is_string($row['author']))
       print $row['quote'] . " - " . $row['author'] . "<br />";      


//$quote = iconv("UTF-8", "ISO-8859-1", $quote);
    

    ?>
  </body>
</html>