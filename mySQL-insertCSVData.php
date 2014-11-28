<?php
/*
Insert raw CSV File Data into MySQL quotes Database

*/
require('global.php');
require('header.php');




$quotes = file("QuotesFromForbes.txt");
$quotes2 = file("QuotesFromBrainyQuote.txt");
$quotes = array_merge($quotes, $quotes2);

$STH = $DBH->prepare("INSERT INTO $dbtable (quote, author) VALUES (?, ?)");
 

for ($i = 0; $i < count($quotes); $i++) {
	$pieces = explode(";", $quotes[$i]);
	$quote = $pieces[0];
	$author = $pieces[1];

	//$quote = utf8_decode($quote);

	if(is_string($quote) AND is_string($author)) {
		$STH->bindParam(1, $quote);
		$STH->bindParam(2, $author);	
		$STH->execute();	
	}
}



$DBH = null;


?>