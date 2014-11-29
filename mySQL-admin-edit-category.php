    <?php    
    require('global.php');
    require('header.php');

    $errors = array();

    print "<h1>Quotes : MySQL Admin : Edit Category</h1>";

    $id = $_GET['id'];

    $dbtable = $dbcategorytable;



    
    


    if(!is_numeric($id)) {  //check to make sure it's a valid number
      array_push($errors, "ID is not a valid number");      
    } else {
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtable . ' WHERE id=?');   //check to make sure this quote ID exists
      $VALSTH->execute(array($id));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if(!$rows[0] > 0) {
        array_push($errors, "Category ID " . $id . " does not exist");
      } else {


        if (isset($_POST['submit'])) {    //form submitted updating quote
          $STH = $DBH->prepare("UPDATE $dbtable SET name=?, status=? WHERE id=?");

          if (validateField($_POST['name']))
            $name = trim($_POST[ 'name' ]);    
          else 
            array_push($errors, "category name field is empty");
          if (validateField($_POST['status']))
            $status = trim($_POST[ 'status' ]);    
          else 
            array_push($errors, "Status field is empty");

          try {
            $STH->bindParam(1, $name);
            $STH->bindParam(2, $status);
            $STH->bindParam(3, $id);          
            $STH->execute();      
            print "<h3>category: \"" . $name . " updated!</h3>";      
          }
          catch(PDOException $e) {
            echo $e->getMessage();
          }
        }

        //get quote ID and print out form


        $STH = $DBH->prepare('SELECT * FROM ' . $dbtable . ' WHERE id=?');
        $STH->execute(array($id));
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $row = $STH->fetch();
        $name = $row['name'];
        $status = $row['status'];
        printTagForm("mySQL-admin-edit-category.php?id=" . $id, $name, $status);            

       }           
    }  

    foreach ($errors as $error) 
      print "<h3>" . $error . "</h3>";    

     



    print '<hr />';

  getSingleQuote($DBH, "quotes");

  require('footer.php'); 
    ?>
