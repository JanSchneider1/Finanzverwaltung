<?php
include __DIR__ . "/../ressources/ContentService.php";
include __DIR__ . "/../ressources/util.php";
include __DIR__ . "/../ressources/templates.php";
$service = new ContentService('derflo@mail.de');
session_start();
setRedirect();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
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

        <!-- LESS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
    </head>

    <header>
         <!-- Header -->
        <?php printHeader(); ?>
        <!-- Title -->
        <br/>
        <h1 class="title">Willkommen</h1>
        <br/>

        <div class="row">

            <div class="container col-lg-4" style="border: white 3px solid;  padding: 0px; background-color: #2F323A">
                <table class="table table-hover table-dark" style="margin: 0px;">
                    <thead>
                        <tr>
                            <th>Letzte Buchungen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(sizeof($service->accountings) == 0){
                                echo "<tr><td style='text-align: center'>Noch keine Buchungen</td></tr>";
                            } else {
                                for ($i = 0; $i < (sizeof($service->accountings) > 5 ? 5 : sizeof($service->accountings)); $i++) {
                                    $color = getValueColor($service->accountings[sizeof($service->accountings) - ($i + 1)]->getIsPositive());
                                    echo "<tr><td style='width: 40%'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getDate() . "</td><td style='text-align: left'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getName() . "</td><td class='$color'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getValue() . "</td></tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="container col-lg-4" style="border: white 3px solid; padding: 0px; background-color: #2F323A">
                <table class="table table-hover table-dark" style="margin: 0px;">
                    <thead>
                    <tr>
                        <th>Kürzlich getätigte Fixa</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $service->reloadAccountings($service->repo->getAccountingsFromFixa($service->user->getUserID()));
                            if(sizeof($service->accountings) == 0){
                                echo "<tr><td style='text-align: center'>Noch keine Fixa getätigt</td></tr>";
                            } else {
                                for ($i = 0; $i < (sizeof($service->accountings) > 5 ? 5 : sizeof($service->accountings)); $i++) {
                                    $color = getValueColor($service->accountings[sizeof($service->accountings) - ($i + 1)]->getIsPositive());
                                    echo "<tr><td style='width: 40%'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getDate() . "</td><td style='text-align: left'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getName() . "</td><td class='$color'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getValue() . "</td></tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    </header>

    <body>

    </body>

</html>