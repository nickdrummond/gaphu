<?php

    require_once("gaphu.php");

    header("content-type: text/xml");

    $dictionary = array("one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten",
    "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty");

    $expression = $_GET["expression"];

    $pos = 0;
    $unrecognized = null;

    preg_match_all("/([^\\s]+)\\s*/", $expression, $matches);

    $tokens = $matches[1]; // the matches for capture group 1

    $count = count($tokens);
    for ($i=0; $i<$count; $i++){
        $token = $tokens[$i];
        if (array_search($token, $dictionary) === FALSE){
            $unrecognized = encode($token);
            break;
        }
        $pos += strlen($token) + 1;
    }

    if ($unrecognized == null){
        $parseSuccess = new ParseSuccess($expression, "OK");
        echo($parseSuccess->getXML());
    }
    else{
        $expectedStr = "Found $unrecognized at position $pos. \nExpected the name of a Number";
//        $count = count($dictionary);
//        for ($i=0; $i<$count; $i++){
//            $expectedStr .= "\n\t" . $dictionary[$i];
//        }
        $parseError = new ParseError($expression, $expectedStr, $pos, $unrecognized);
        echo($parseError->getXML());
    }
?>