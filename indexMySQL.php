    <?php
    require('global.php');
    require('header.php');

print '<div class="quote" id="quoteBody">';

  $STH = $DBH->query('SELECT quote, author FROM ' . $dbtable . ' AS quotetbl JOIN
    (SELECT (RAND() * (SELECT MAX(id) FROM ' . $dbtable . ')) AS id) AS r2
    WHERE quotetbl.id >= r2.id
    ORDER BY quotetbl.id ASC LIMIT 1');
    //http://jan.kneschke.de/projects/mysql/order-by-rand/

    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $row = $STH->fetch();
    if(is_string($row['quote']) AND is_string($row['author']))
       print $row['quote'] . " - " . $row['author'] . "<br />";      

    echo '</div><div class="nextButton" style="text-align:center;"><button id="nextBtn" class="nextBtn" type="button">NEXT</button></div>';

//$quote = iconv("UTF-8", "ISO-8859-1", $quote);
    
     require('footer.php');
    ?>
