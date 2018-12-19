<?php
/**
 * Created by IntelliJ IDEA.
 * User: jschneider
 * Date: 05.12.2018
 * Time: 09:38
 */
function convertValue($value, $isPositive){

    $valueString = (String)number_format((float)$value, 2, ',', '')." €";
    if ($isPositive == 1){ $valueString = "+ ".$valueString; }
    else{ $valueString = "- ".$valueString; }
    return $valueString;

}

function getValueColor($isPositive){

    if ($isPositive == 1) {
        return "positive";
    } else {
        return "negative";
    }
}

function toCharJSLabels($array){

    //Add more ' , because else they don't survive implode()
    for($i = 0, $size = count($array); $i < $size; ++$i) {
        $array[$i] = "'".$array[$i]."'";
    }
    return "[".implode(",",$array)."]";
}

function toCharJSData($array){

    return "[".implode(",",$array)."]";
}