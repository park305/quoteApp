    <?php
    $title = "Inspiring Quotes v1: Edit Tags";

    require('global.php');
    require('header.php');

    print "<h1>Quotes : MySQL Admin : Edit Tags</h1>";

    $STH = $DBH->query('SELECT * FROM ' . $dbtagstable . ' ORDER BY name');
    //http://jan.kneschke.de/projects/mysql/order-by-rand/
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    
    ?>
    <table border="1">
      <thead>
        <th>ID</th>
        <th>Tag</th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <tbody>        
    <?php
    while( $row = $STH->fetch() ) {
      if( is_string($row['name']) AND is_string( $row['status'] ) )
         print "<tr><td>" . $row['id'] . "</td><td><a href=\"mysql-tag.php?tag=" . $row['name'] . "\">" . $row['name'] . "</td><td>" . $row['status'] . "</td><td><a href=\"mySQL-admin-edit-tag.php?id=" . $row['id'] . "\">Edit</a></td><td><a href=\"mySQL-admin-delete-tag.php?id=" . $row['id'] . "\">Delete</a></td></tr>";      
     }

    ?>
      </tbody>
    </table>
    <a href="mySQL-admin-addTag.php">Add New Tag</a>
<?php
require ('footer.php');
?>