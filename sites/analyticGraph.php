<?php
/**
 * Created by PhpStorm.
 * User: Niklas
 * Date: 11.01.2019
 * Time: 18:52
 */
include __DIR__ . "/../ressources/templates.php";
include __DIR__ . "/../ressources/Repository.php";
include __DIR__ . "/../ressources/ContentService.php";
session_start();
?>
<!DOCTYPE 'html'>
<html lang='en' xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>PHP-Projekt</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <!-- Glyphicons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css">

    <!-- My stylesheets -->
    <link rel="stylesheet" href="../css/assets/texteffects.css">
    <link rel="stylesheet" href="../css/assets/hover-min.css">
    <link rel="stylesheet/less" type="text/css" href="../css/general.less">
</head>
<header>
    <?php printHeader(); ?>
</header>
<body>
    <div>
        <canvas id='myCanvas'></canvas>
    </div>
</body>
<footer>
    <?php printFooter(); ?>
</footer>
</html>
