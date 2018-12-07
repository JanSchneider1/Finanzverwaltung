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
    $categoryName = htmlspecialchars($_POST['addAccounting_categoryName']);
    $isPositive = htmlspecialchars($_POST['addAccounting_isPositive']);

    //Convert -> Get isPositive (0 or 1)
    $_isPositive;
    if ($isPositive == "Einnahmen") { $_isPositive = 1;}
    else if ($isPositive == "Ausgaben") { $_isPositive = 0;}

    //Convert -> Get CategoryID by Name from user
    $categoryID = 1;

    //Try to add accounting with specific values
    echo var_dump($service->repo->createAccountingForUser(1, "Essen", $value, 1, "27-01-12", 1));

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