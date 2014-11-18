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

    print '
    <form action="mySQL-admin-quoteSubmit.php" method="post">
        <label for="quote">Quote:</label> <textarea id="quote" name="quote"></textarea> <br />
        <label for="author">Author: </label> <input type="text" id="author" name="author" /><br />
      <input type="submit" />
    </form>
    ';

    print '<hr />';



  $STH = $DBH->query('SELECT quote, author FROM ' . $dbtable . ' AS quotetbl JOIN
    (SELECT (RAND() * (SELECT MAX(id) FROM ' . $dbtable . ')) AS id) AS r2
    WHERE quotetbl.id >= r2.id
    ORDER BY quotetbl.id ASC LIMIT 1');
    //http://jan.kneschke.de/projects/mysql/order-by-rand/

    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $row = $STH->fetch();
    if(is_string($row['quote']) AND is_string($row['author']))
       print $row['quote'] . " - " . $row['author'] . "<br />";      


    

    ?>
  </body>
</html>