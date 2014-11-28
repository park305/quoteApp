<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes v1</title>
  </head>
  <body>
    <?php
    require('global.php');
    $errors = array();

    $id = $_GET['id'];

    if(is_numeric($id)) { 
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE id=?');
      $VALSTH->execute( array($id) );
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
        //check to see if quote already exists?

      if($rows[0] > 0) {
        try {
          $STH = $DBH->prepare('SELECT * FROM ' . $dbtable . ' WHERE id=?');
          $STH->execute( array($id) );          
          $rows = $STH->fetch(PDO::FETCH_NUM);

          $STH->bindParam(1, $id);
          $STH->execute();     

          $STH->setFetchMode(PDO::FETCH_ASSOC);
          $row = $STH->fetch();           
          if(is_string($row['quote']) AND is_string($row['author']))
             print $row['quote'] . " - " . $row['author'] . "<br />";      

        }
        catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
      } else {
        array_push($errors, "Quote ID " . $id . " does not exist");        
      }      
    } else {
      array_push($errors, "ID is not a valid number");      
    }
    

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     


    ?>
  </body>
</html>