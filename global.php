<?php
	require('config.php');
    
  function connectDB($dbtype, $host, $dbname, $dbuser, $dbpass) {
    try {
      # MySQL with PDO_MYSQL
      $DBH = new PDO("$dbtype:host=$host;dbname=$dbname", $dbuser, $dbpass);
      $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $DBH;
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    }
  }

  $DBH = connectDB($dbtype, $host, $dbname, $dbuser, $dbpass);




    function printQuoteForm($url, $quote, $author, $DBH = null) {
      //$DBH = connectDB();
      $tagRadioElements = "";
      $categoryDropDown = "";


      $STH = $DBH->query("SELECT * FROM categories WHERE status='Active' ORDER BY name");
      $STH->setFetchMode(PDO::FETCH_ASSOC);
      $categoryDropDown = '<select name="category" id="category">';      
      while( $row = $STH->fetch() ) {
        if(is_string($row['name']) AND $row['status'] == "Active")
           $categoryDropDown .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
      }
      $categoryDropDown .= "</select>";

      $STH = $DBH->query("SELECT * FROM tags WHERE status='Active' ORDER BY name");
      $STH->setFetchMode(PDO::FETCH_ASSOC);
      while( $row = $STH->fetch() ) {
        if(is_string($row['name']) AND $row['status'] == "Active")
           $tagRadioElements .= '<input type="checkbox" id="tags" name="tags[]" value="' . $row['name'] . '"> ' . $row['name'] . '<br />';
      }


      print '
      <form action="' . $url . '" method="post">
          <label for="quote">Quote:</label> <textarea id="quote" name="quote">' . $quote . '</textarea> <br />
          <label for="author">Author: </label> <input type="text" id="author" value="' . $author . '" name="author" /><br />
          <label for="tags">Tags: </label>
          ' . $tagRadioElements . '
          <label for="category">Category: </label>
          ' . $categoryDropDown . '

        <input type="submit" name="submit" value="Submit" />
      </form>
      ';
    }

    function printCategoryForm($url, $name, $status) {
      $statusActivefield = '<option value="Active">Active</option>';
      $statusInactivefield = '<option value="Inactive">Hide</option>';

      if($status == "Active")
        $statusActivefield = '<option value="Active" selected>Active</option>';
      else if($status == "Inactive")
        $statusInactivefield = '<option value="Inactive" selected>Hide</option>';

      print '
      <form action="' . $url . '" method="post">
          <label for="quote">Category:</label> <input type="text" id="name" name="name" value="' . $name . '" /><br />
          <label for="author">Status: </label> 
          <select name="status" id="status">' . $statusActivefield . $statusInactivefield . '          
          </select><br />

        <input type="submit" name="submit" value="Submit" />
      </form>
      ';
    }
    function printTagForm($url, $name, $status) {
      $statusActivefield = '<option value="Active">Active</option>';
      $statusInactivefield = '<option value="Inactive">Hide</option>';

      if($status == "Active")
        $statusActivefield = '<option value="Active" selected>Active</option>';
      else if($status == "Inactive")
        $statusInactivefield = '<option value="Inactive" selected>Hide</option>';

      print '
      <form action="' . $url . '" method="post">
          <label for="quote">Tag:</label> <input type="text" id="name" name="name" value="' . $name . '" /><br />
          <label for="author">Status: </label> 
          <select name="status" id="status">' . $statusActivefield . $statusInactivefield . '          
          </select><br />

        <input type="submit" name="submit" value="Submit" />
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