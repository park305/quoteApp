<?php
libxml_use_internal_errors(true);
print "Program Starting...<br />";
$ouFilename = "QuotesFromBrainyQuote.txt";
$outfile = fopen($ouFilename, "wb");


$url = "http://www.brainyquote.com/quotes/topics/topic_inspirational.html?vm=l";

for($i=1;$i<12;$i++) {
	if($i>1)
		$url = "http://www.brainyquote.com/quotes/topics/topic_inspirational" . $i . ".html?vm=l";
				
	$dom = new DOMDocument;
	$dom->loadHTMLFile($url);
	$dom_xpath = new DOMXpath($dom);

	$elements = $dom_xpath->query("//div[@class='boxyPaddingBig']");
	if (!is_null($elements)) {
	  foreach ($elements as $element) {

		$node = $dom_xpath->query("span[@class='bqQuoteLink']", $element);
		$quote = $node->item(0)->nodeValue;
		//print $node->item(0)->nodeValue . "<br />";
		$node = $dom_xpath->query("div[@class='bq-aut']", $element);
		$author = $node->item(0)->nodeValue;
		//print $node->item(0)->nodeValue . "<br />";

		$quote = str_replace(";", ".", $quote);
        $quote = utf8_encode(trim($quote));
        $author = utf8_encode(trim($author));
        fwrite($outfile, $quote . ";" . $author . "\r\n");
	  }
	}


}






fclose($outfile);
print 'Program Finished, go see your <a href="'. $ouFilename . '">new file</a>';


?>