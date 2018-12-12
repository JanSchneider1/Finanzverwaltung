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

    /*
    //Debugging
    $value = 100;
    $name = "Debug";
    $date = "2000-01-12";
    $categoryID = 1;
    $flag = "Ausgaben";
    $isPositive = 0;
    */

    //Convert -> Get isPositive (0 or 1)
    $isPositive = -1;
    if (strcmp($flag,'Einnahmen') == 0) { $isPositive = 1;}
    else if (strcmp($flag,'Ausgaben') == 0) { $isPositive = 0; $value *= -1;}
    if ($isPositive == -1) { return; }

    if ($categoryID == '/'){ $categoryID = null;}

    //Try to add accounting with specific values
    $service->repo->createAccountingForUser(1, $name, $value, $isPositive, $date, $categoryID);
    $accounting = $service->repo->getLatestAccountingByUser(1);

    //Build response
    $categoryName = "/";
    $category = $service->repo->getCategoryByID($accounting['CategoryID']);
    if ($category != null) {$categoryName = $category[0]["Name"];}
    $response = array (
        "accountingID"  => $accounting["AccountingID"],
        "value"         => $accounting["Value"],
        "name"          => $accounting["Name"],
        "date"          => $accounting["Date"],
        "categoryName"  => $categoryName,
        "isPositive"    => $accounting["IsPositive"]
    );

    //Encode as JSON
    print_r(json_encode($response));
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