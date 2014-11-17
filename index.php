<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Inspiring Quotes v1</title>
  </head>
  <body>
    <?php
    $quotes = file("QuotesFromForbes.txt");
    $quotes2 = file("QuotesFromBrainyQuote.txt");
    $quotes = array_merge($quotes, $quotes2);

    $randNum = rand(0, count($quotes)-1);
    $pieces = explode(";", $quotes[$randNum]);
    $quote = $pieces[0];
    $author = $pieces[1];
    if(is_string($quote) AND is_string($author))
       print $pieces[0] . " - " . $pieces[1];
     else
      print "Error";

    ?>
  </body>
</html>