<?php
	require('config.php');
    

    try {
      # MySQL with PDO_MYSQL
      $DBH = new PDO("$dbtype:host=$host;dbname=$dbname", $dbuser, $dbpass);
      $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    }




    function printQuoteForm($url, $quote, $author) {
      print '
      <form action="' . $url . '" method="post">
          <label for="quote">Quote:</label> <textarea id="quote" name="quote">' . $quote . '</textarea> <br />
          <label for="author">Author: </label> <input type="text" id="author" value="' . $author . '" name="author" /><br />
        <input type="submit" name="submit" value="Update" />
      </form>
      ';
    }

    function validateField($field) {
      if (isset($field) AND is_string($field) AND strlen($field) > 0) 
        return true;
      else 
        return false;
    }

    function getSingleQuote($DBH, $dbtable) {
	  $STH = $DBH->query('SELECT quote, author FROM ' . $dbtable . ' AS quotetbl JOIN
	    (SELECT (RAND() * (SELECT MAX(id) FROM ' . $dbtable . ')) AS id) AS r2
	    WHERE quotetbl.id >= r2.id
	    ORDER BY quotetbl.id ASC LIMIT 1');
	    //http://jan.kneschke.de/projects/mysql/order-by-rand/

	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    $row = $STH->fetch();
	    if(is_string($row['quote']) AND is_string($row['author']))
	       print $row['quote'] . " - " . $row['author'] . "<br />";      
    }

?>