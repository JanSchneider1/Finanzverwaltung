<?php

//Setup
require __DIR__ . "/../ressources/ContentService.php";
session_start();
if (!$_SESSION["userId"]) {
    die;
}
$service = new ContentService($_SESSION["email"]);

//POST REQUEST
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Get values from form
    $name = htmlspecialchars($_POST['addCategory_name']);

    if ($name == ''){ die;}

    //Try to add category with specific values
    $service->repo->createCategoryForUser($service->user->getUserID(), $name);
    $service->reloadCategories($service->repo->getCategoriesByUser($service->user->getUserID()));
    $category = $service->categories[sizeof($service->categories) - 1];
    //Build response
    $response = array (
        "categoryID"  => $category->getID(),
        "name"          => $category->getName(),
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

    //Try deleting category with id
    $service->repo->deleteCategory($id);
}
//PUT REQUEST
else if($_SERVER['REQUEST_METHOD'] == 'PUT') {

    //Get URL
    $url = $_SERVER['REQUEST_URI'];

    //Get Params (-> id) from URL
    $parsed = parse_url($url);
    $query = $parsed['query'];
    parse_str($query, $params);
    $id = $params['id'];
    $name = $params['name'];

    if($name == ''){die;}
    //Try updating category with id
    $service->repo->alterCategoryName($id, $name);
}