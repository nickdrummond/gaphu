<?php

    require_once("gaphu.php");

    header("content-type: text/xml");

    $dictionary = array("one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten",
        "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty");

    $expression = $_GET["expression"];

    $lastSpace = strrpos($expression, " ");
    if ($lastSpace === FALSE){
        $lastSpace = 0;
    }
    else{
        $lastSpace++; // TODO what about other whitespace?
    }
    $lastWord = substr($expression, $lastSpace);
    $lastWordLen = strlen($lastWord);

    $matchingTerms = array();

    $count = count($dictionary);
    for ($i=0; $i<$count; $i++){
        $term = $dictionary[$i];
        $start = substr($term, 0, $lastWordLen);
        if ($start == $lastWord){
            array_push($matchingTerms, $term);
        }
    }

    $result = new AutocompleteResult($expression, $lastSpace, $lastWord);
    $result->addExpected("Number", $matchingTerms);

    echo($result->getXML());
?>