<?php

//Setup
require __DIR__ . "/../ressources/ContentService.php";
$service = new ContentService('derflo@mail.de');

//POST REQUEST
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get values from form
    $value = htmlspecialchars($_POST['addFixum_value']);
    $name = htmlspecialchars($_POST['addFixum_name']);
    $date = htmlspecialchars($_POST['addFixum_date']);
    $categoryID = htmlspecialchars($_POST['addFixum_categoryID']);
    $flag = htmlspecialchars($_POST['addFixum_isPositive']);
    $frequency = htmlspecialchars($_POST['addFixum_frequency']);

    //Convert -> Get isPositive (0 or 1)
    $isPositive = -1;
    if (strcmp($flag,'Einnahmen') == 0) { $isPositive = 1;}
    else if (strcmp($flag,'Ausgaben') == 0) { $isPositive = 0; $value *= -1;}
    if ($isPositive == -1 || $value == 0 || $name == "") {echo"\nbreak"; die;}

    //Try to add fixum
    $service->repo->createFixumForUser($service->user->getUserID(), $name, $value, $isPositive, $date, $frequency, $categoryID);
    $service->reloadFixa($service->repo->getFixaByUser($service->user->getUserID()));
    $fixum = $service->fixa[sizeof($service->fixa) - 1];

    switch($fixum->getFrequency()){
        case 'DAY':
            $frequency = 'Täglich';
            break;
        case 'WEEK':
            $frequency = 'Wöchentlich';
            break;
        case 'MONTH':
            $frequency = 'Monatlich';
            break;
        case 'QUARTER':
            $frequency = 'Vierteljährlich';
            break;
        case 'YEAR':
            $frequency = 'Jährlich';
            break;
    }

    //Build response
    $categoryName = "Nicht zugeordnet";
    $category = $service->repo->getCategoryByID($fixum->getCategoryID());
    if ($category != null) {$categoryName = $category[0]["Name"];}
    $response = array (
        "fixumID"  => $fixum->getFixumID(),
        "startDate"     => $fixum->getStartDate(),
        "lastUsedDate"  => $fixum->getLastUsedDate(),
        "name"          => $fixum->getName(),
        "categoryName"  => $categoryName,
        "isPositive"    => $fixum->getisPositive(),
        "value"         => $fixum->getValue(),
        "frequency"     => $frequency,
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

    //Try deleting fixum with id
    $service->repo->deleteFixum($id);
}