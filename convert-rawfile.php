<?php
$filename = "rawfile-QuotesFromForbes.txt";
$fp = fopen($filename, "r");
    while (($buffer = fgets($fp, 4096)) !== false) {
    	if(strlen($buffer) > 3) {
    		$line = $buffer;
    		$line = substr($line, strpos($buffer, " ")+1);    //skips the quote # at beginning of line

            $end_point = findQuoteEnd($line);
            $author = substr($line, $end_point+1);
            $quote = substr($line, 0, $end_point);

            print $quote . "by " . $author . "<br />";
        }
    }
    if (!feof($fp)) {
        echo "Error: unexpected fgets() fail\n";
    }
fclose($fp);


function findQuoteEnd($line) {
    $line = trim($line);
    for ($i = strlen($line)-1; $i>0; $i--) {
        $letter = $line[$i];
        if (!preg_match('/[a-zA-Z]/', $letter) AND $letter != "." AND $letter != " ") 
            return $i;
            //return substr($line, $i+1);            
    }
}

?>