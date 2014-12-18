    <?php
    $title = "Inspiring Quotes v1: Edit Categories";

    require('global.php');
    require('header.php');
    $dbtable = $dbcategorytable;
    print "<h1>Quotes : MySQL Admin : Edit Categories</h1>";

    $STH = $DBH->query('SELECT * FROM ' . $dbtable);
    //http://jan.kneschke.de/projects/mysql/order-by-rand/
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    
    ?>
    <table border="1">
      <thead>
        <th>ID</th>
        <th>Category</th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>
      </thead>
      <tbody>        
    <?php
    while( $row = $STH->fetch() ) {
      if( is_string($row['name']) AND is_string( $row['status'] ) )
         print "<tr><td>" . $row['id'] . "</td><td><a href=\"mysql-category.php?category="  . $row['name'] . "\">"  . $row['name'] . "</a></td><td>" . $row['status'] . "</td><td><a href=\"mySQL-admin-edit-category.php?id=" . $row['id'] . "\">Edit</a></td><td><a href=\"mySQL-admin-delete-category.php?id=" . $row['id'] . "\">Delete</a></td></tr>";      
     }

    ?>
      </tbody>
    </table>
    <a href="mySQL-admin-addCategory.php">Add New Category</a>

<?php
require ('footer.php');
?>