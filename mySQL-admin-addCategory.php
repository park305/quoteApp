    <?php
    $title = "Inspiring Quotes : Administrator Add Category";

    require('global.php');
    require('header.php');

    $dbtable = $dbcategorytable;
    print "<h1>Quotes : MySQL Admin : Add Category</h1>";
    $name = "";
    $status = "";

    if (isset($_POST['submit'])) {
      $STH = $DBH->prepare("INSERT INTO $dbtable (name, status) VALUES (?, ?)");
      $errors = array();

      if (validateField($_POST['name']))
        $name = trim($_POST[ 'name' ]);    
      else 
        array_push($errors, "Category field is empty");
      if (validateField($_POST['status']) AND ( $_POST['status'] == "Active" OR $_POST['status'] == "Inactive" ))      
        $status = trim($_POST[ 'status' ]);    
      else 
        array_push($errors, "Status field is empty");
      
        //check to see if quote already exists?
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtagstable . ' WHERE name=?');
      $VALSTH->execute(array($name));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if($rows[0] > 0) {
        array_push($errors, "Category already exists in database.");
      }


    
      if (count ($errors) == 0) {
        try {
          $STH->bindParam(1, $name);
          $STH->bindParam(2, $status);  
          $STH->execute();      
          print "<h3>Category: \"" . $name . "\" with status " . $status . " added!</h3>";      
          $name = $status = "";
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            exit;
        }
      } else {
        foreach ($errors as $error) 
          print "<h3>" . $error . "</h3>";
      }

      print "<hr />";
    } 

    printCategoryForm("mySQL-admin-addCategory.php", $name, $status);            

    print '<hr />';

  getSingleQuote($DBH, "quotes");

  require('footer.php');    
    ?>
