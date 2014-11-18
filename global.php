<?php
	require('config.php');
    try {
      # MySQL with PDO_MYSQL
      $DBH = new PDO("$dbtype:host=$host;dbname=$dbname", $dbuser, $dbpass);
      $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        exit;
    }

?>