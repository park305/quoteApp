<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes v1</title>
  </head>
  <body>
    <?php
    $quotes = file("QuotesFromForbes.txt");
    $randNum = rand(0, count($quotes));
    $pieces = explode(";", $quotes[$randNum]);
    print $pieces[0];
    //print utf8_encode($pieces[0]);

    ?>
  </body>
</html>