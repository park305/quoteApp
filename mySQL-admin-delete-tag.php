    <?php    
    require('global.php');
    require('header.php');

    $errors = array();

    print "<h1>Quotes : MySQL Admin : Delete Tag</h1>";

    $id = $_GET['id'];
    $dbtable = $dbtagstable;

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
          print "ID " . $id . " deleted<br />";
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
      } else {
        array_push($errors, "Tag ID " . $id . " does not exist");        
      }      
    } else {
      array_push($errors, "ID is not a valid number");      
    }
    

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     



    print '<hr />';

  getSingleQuote($DBH, "quotes");

  require('footer.php'); 
    ?>
