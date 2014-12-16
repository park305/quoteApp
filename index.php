    <?php
    require('header.php');

    $quotes = file("QuotesFromForbes.txt");
    $quotes2 = file("QuotesFromBrainyQuote.txt");
    $quotes = array_merge($quotes, $quotes2);

print '<div class="quote" id="quoteBody">';
    $randNum = rand(0, count($quotes)-1);
    $pieces = explode(";", $quotes[$randNum]);
    $quote = $pieces[0];
    $author = $pieces[1];
    if(is_string($quote) AND is_string($author))
       print $pieces[0] . "<br /> - " . $pieces[1];
     else
      print "Error";


    echo '</div><div class="nextButton" style="text-align:center;"><button id="nextBtn" class="nextBtn" type="button">NEXT</button></div>';
    require("footer.php");
?>