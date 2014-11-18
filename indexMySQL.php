<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes v1</title>
  </head>
  <body>
    <?php
    require('global.php');

  $STH = $DBH->query('SELECT quote, author FROM ' . $dbtable . ' AS quotetbl JOIN
    (SELECT (RAND() * (SELECT MAX(id) FROM ' . $dbtable . ')) AS id) AS r2
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