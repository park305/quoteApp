<?php
$filename = "rawfile-QuotesFromForbes.txt";
$fp = fopen($filename, "r");
    while (($buffer = fgets($fp, 4096)) !== false) {
    	if(strlen($buffer) > 3) {
    		$line = $buffer;
    		$line = substr($line, strpos($buffer, " ")+1);    //skips the quote # at beginning of line

    		//$pieces = explode(" –", $line);
    /*        $pos = strpos($line, ".");
            print substr($line, $pos+2,1) . "<Br />";
            $pos = strpos($line, substr($line, $pos+2,1));
            print $pos . "<br />";
            $pieces = explode(substr($line, $pos+2,1), $line);


    		$author = $pieces[1] . "<Br />";
            print $author;
            print_r($pieces);
      */  	

            $period_pos = strrpos($line, ".");
            $question_pos = strrpos($line, "?");
            $exclaim_pos = strrpos($line, "!");            
            $end_pos = $question_pos;
            if ($period_pos > $question_pos && $period_pos > $exclaim_pos)
                $end_pos = $period_pos;
            else if ($exclaim_pos > $period_pos && $exclaim_pos > $question_pos)
                $end_pos = $exclaim_pos;

            print cleanUpAuthorName(findAuthorName($line)) . "<br />";

            $quote = substr($line, 0, $end_pos+1);
            if (!preg_match('/[a-zA-Z]/', substr($line, $end_pos+1, 1)))  //this is Audrey's line that goes "sdfsfss." - Audrey, need to get the "
            {
                $quote .= substr($line, $end_pos+1, 1);
            }
            
            //echo substr($line, 0, $end_pos+1) . "<br />";
            print $quote . "<br />";
        }
    }
    if (!feof($fp)) {
        echo "Error: unexpected fgets() fail\n";
    }
fclose($fp);




function findAuthorName($line) {
    $period_pos = strrpos($line, ".");
    $question_pos = strrpos($line, "?");
    $exclaim_pos = strrpos($line, "!");
    if ($exclaim_pos > $period_pos && $exclaim_pos > $question_pos)     //change depend on whether quote ends with what punctuation
        $words = explode("!", $line);
    else if ($period_pos > $exclaim_pos && $period_pos > $question_pos)
        $words = explode(".", $line);
    else if ($question_pos > $period_pos && $quesiton_pos > $exclaim_pos)
        $words = explode("?", $line);


    $total = count($words);
    if (strlen($words[$total-1]) <= 3)       //in this case for MArtin Luther King Jr., aka if last word is empty space then use previous word, using 3 because of newline chars
        return $words[$total-2];

    $author = $words[$total-1];


    $second_to_last_word =  $words[$total-2];       
    $verify_words = explode(" " , $second_to_last_word);
    $total_verify_words = count($verify_words);
    $last_word = $verify_words[$total_verify_words-1];

    if (!preg_match('/[a-zA-Z]/', $last_word[0]))  //this is for W. Clementon Stone
        return $last_word . " " . $author;
    else if ( strlen( $last_word ) == 1)    //this case is for Brooker T. Washington, adding back in the Brooker T
        return $verify_words[ $total_verify_words-2 ] . " " . $last_word . $author;

    return $author;            

}

function cleanUpAuthorName($author) {
    if (!preg_match('/[a-zA-Z]/', $author[0]))  {   //this is for:   ." -Audrey Hepburn & to just remove the dash -
        for ($i = 0; $i < strlen($author); $i++) {
            $letter = $author[$i];
            if (preg_match('/[a-zA-Z]/', $letter))  {   
                $author = substr($author, $i);
                break;
            }
        }
    }
    return $author;    
}
?>