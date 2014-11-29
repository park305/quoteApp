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
      <li> <a href="mySQL-admin-manageTags.php">Manage Tags</a></li>
      <li> <a href="mySQL-admin-manageCategories.php">Manage Categories</a></li>
    </ul>
    ';

    print '<hr />';


  getSingleQuote($DBH, "quotes");

    
     require('footer.php');
    ?>
