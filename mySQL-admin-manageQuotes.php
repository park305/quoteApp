    <?php
    $title = "Inspiring Quotes v1: Edit Quotes";
    
    require('global.php');
    require('header.php');

    print "<h1>Quotes : MySQL Admin : Edit Quotes</h1>";

    $STH = $DBH->query('SELECT id, quote, author FROM ' . $dbtable . ' ORDER BY author');
    //http://jan.kneschke.de/projects/mysql/order-by-rand/
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    
    ?>
    <table border="1">
      <thead>
        <th>ID</th>
        <th>Quote</th>
        <th>Author</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <tbody>        
    <?php
    while( $row = $STH->fetch() ) {
      if( is_string($row['quote']) AND is_string( $row['author'] ) )
         print "<tr><td>" . $row['id'] . "</td><td>" . $row['quote'] . " </td><td>" . $row['author'] . "</td><td><a href=\"mySQL-admin-edit.php?id=" . $row['id'] . "\">Edit</a></td><td><a href=\"mySQL-admin-delete.php?id=" . $row['id'] . "\">Delete</a></td></tr>";      
     }

    ?>
      </tbody>
    </table>
  </body>
</html>