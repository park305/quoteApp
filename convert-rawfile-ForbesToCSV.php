<?php
/*
Oct 2014
Version 1 

Input: $filename = "rawfile-QuotesFromForbes.txt";
Output: $ouFilename = "QuotesFromForbes.txt";

Raw file is from: http://www.forbes.com/sites/kevinkruse/2013/05/28/inspirational-quotes/

This script will read this raw file and convert it into a data CSV file for the site to use to randomly grab quotes from.

For unknown reason, PHP cannot read/understand the "-" dash hypen character. I tried doing strpos($line, "-") or explode("-", $line) and it doesn't work.
Hence the function findQuoteend() existence
*/

print "Program Starting...<br />";
$ouFilename = "QuotesFromForbes.txt";
$outfile = fopen($ouFilename, "wb");
fwrite($outfile, pack("CCC",0xef,0xbb,0xbf)); 


$filename = "rawfile-QuotesFromForbes.txt";
$fp = fopen($filename, "rb");

    while (($buffer = fgets($fp, 4096)) !== false) {
    	if( mb_strlen($buffer) > 3 ) {
    		$line = $buffer;
    		$line = mb_substr( $line, mb_strpos( $buffer, " " ) +1 );    //skips the quote # at beginning of line

            $end_point = findQuoteEnd( $line );
            $author = trim( mb_substr( $line, $end_point+1 ) );
            $quote = trim( mb_substr( $line, 0, $end_point-2 ));
            $quote = str_replace( ";", ".", $quote );

            //print $quote . "by " . $author . "<br />";
          //  $quote = utf8_encode($quote);
            //$author = utf8_encode($author);
            //fputs($outfile, $string);
            fwrite( $outfile, $quote . ";" . $author . "\r\n" );
        }
    }
    if (!feof( $fp ) ) {
        echo "Error: unexpected fgets() fail\n";
    }
fclose($fp);
fclose($outfile);
print 'Program Finished, go see your <a href="'. $ouFilename . '">new file</a>';


function findQuoteEnd($line) {
    $line = trim($line);
    for ($i = mb_strlen($line)-1; $i>0; $i--) {
        $letter = $line[$i];
        if ( !preg_match( '/[a-zA-Z]/', $letter ) AND $letter != "." AND $letter != " " ) 
            return $i;
    }
}

?>