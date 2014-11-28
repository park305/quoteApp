<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes : Administrator Add Quote</title>
  </head>
  <body>
    <?php    
    require('global.php');
    $errors = array();

    print "<h1>Quotes : MySQL Admin : Delete Quote</h1>";

    $id = $_GET['id'];


    if(is_numeric($id)) { 
      $STH = $DBH->prepare("DELETE FROM $dbtable WHERE id=?");

        //check to see if quote already exists?
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE id=?');
      $VALSTH->execute(array($id));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if($rows[0] > 0) {
        try {
          $STH->bindParam(1, $id);
          $STH->execute();      
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

     



    print '<hr />';

  getSingleQuote($DBH, $dbtable);

 
    ?>
  </body>
</html>