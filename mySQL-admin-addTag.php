    <?php
    $title = "Inspiring Quotes : Administrator Add Tag";

    require('global.php');
    require('header.php');


    print "<h1>Quotes : MySQL Admin : Add Tag</h1>";
    $name = "";
    $status = "";

    if (isset($_POST['submit'])) {
      $STH = $DBH->prepare("INSERT INTO $dbtagstable (name, status) VALUES (?, ?)");
      $errors = array();

      if (validateField($_POST['name']))
        $name = trim($_POST[ 'name' ]);    
      else 
        array_push($errors, "Tag field is empty");
      if (validateField($_POST['status']) AND ( $_POST['status'] == "Active" OR $_POST['status'] == "Inactive" ))
        $status = trim($_POST[ 'status' ]);    
      else 
        array_push($errors, "Status field is empty");
      
        //check to see if quote already exists?
      $VALSTH = $DBH->prepare('SELECT count(id) FROM ' . $dbtagstable . ' WHERE name=?');
      $VALSTH->execute(array($name));
      $rows = $VALSTH->fetch(PDO::FETCH_NUM);
      if($rows[0] > 0) {
        array_push($errors, "Tag already exists in database.");
      }


    
      if (count ($errors) == 0) {
        try {
          $STH->bindParam(1, $name);
          $STH->bindParam(2, $status);  
          $STH->execute();      
          print "<h3>Tag: \"" . $name . "\" with status " . $status . " added!</h3>";      
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

    printTagForm("mySQL-admin-addTag.php", $name, $status);            

    print '<hr />';

  getSingleQuote($DBH, "quotes");

  require('footer.php');    
    ?>
