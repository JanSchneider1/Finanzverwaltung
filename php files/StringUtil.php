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