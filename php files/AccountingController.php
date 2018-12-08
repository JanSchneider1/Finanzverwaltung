<?php

//Setup
require __DIR__ . "/ContentService.php";
$service = new ContentService('derflo@mail.de');

//POST REQUEST
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get values from form
    $value = htmlspecialchars($_POST['addAccounting_value']);
    $name = htmlspecialchars($_POST['addAccounting_name']);
    $date = htmlspecialchars($_POST['addAccounting_date']);
    $categoryID = htmlspecialchars($_POST['addAccounting_categoryID']);
    $flag = htmlspecialchars($_POST['addAccounting_isPositive']);

    //Convert -> Get isPositive (0 or 1)
    $isPositive = -1;
    if (strcmp($flag,'Einnahmen') == 0) { $isPositive = 1;}
    else if (strcmp($flag,'Ausgaben') == 0) { $isPositive = 0;}
    if ($isPositive == -1) { return; }

    if ($categoryID == '/'){ $categoryID = null;}

    //Try to add accounting with specific values
    echo var_dump($service->repo->createAccountingForUser(1, $name, $value, $isPositive, $date, $categoryID));

}

//DELETE REQUEST
else if($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    //Get URL
    $url = $_SERVER['REQUEST_URI'];

    //Get Params (-> id) from URL
    $parsed = parse_url($url);
    $query = $parsed['query'];
    parse_str($query, $params);
    $id = $params['id'];

    //Try deleting accounting with specific id
    echo var_dump($service->repo->deleteAccounting($id));

}