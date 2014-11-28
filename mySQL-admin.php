    <?php
    $title = "Inspiring Quotes : Administrator Index";
    
    require('global.php');
    require('header.php');


    print "<h1>Quotes : MySQL Admin</h1>";

    print '
    <ul>
      <li> <a href="mySQL-admin-addQuote.php">Add New Quote</a></li>
      <li> <a href="mySQL-admin-manageQuotes.php">Edit/Delete Quotes</a></li>
      <li> <a href="mySQL-admin-uploadCSV.php">Upload CSV of Quotes</a></li>
    </ul>
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