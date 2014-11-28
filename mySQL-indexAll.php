<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes v1</title>
  </head>
  <body>
    <?php
    require('global.php');

    $STH = $DBH->query('SELECT quote, author FROM ' . $dbtable . ' ORDER BY author');
    //http://jan.kneschke.de/projects/mysql/order-by-rand/

    $STH->setFetchMode(PDO::FETCH_ASSOC);
    

    while( $row = $STH->fetch() ) {
      if( is_string($row['quote']) AND is_string( $row['author'] ) )
         print $row['quote'] . " - " . $row['author'] . "<br />";      
     }


//$quote = iconv("UTF-8", "ISO-8859-1", $quote);
    

    ?>
  </body>
</html>