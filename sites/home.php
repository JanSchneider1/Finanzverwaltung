<?php
include __DIR__ . "/../ressources/ContentService.php";
include __DIR__ . "/../ressources/util.php";
include __DIR__ . "/../ressources/templates.php";
session_start();
setRedirect();
$service = new ContentService($_SESSION["email"]);
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
        <!-- ChartJS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    </head>

    <header>
         <!-- Header -->
        <?php printHeader(); ?>
    </header>

    <body>
        <!-- Title -->
        <br/>
        <h1 class="title">Willkommen</h1>
        <br/>

        <div class="row" style="margin: 0px;">
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
                                echo "<tr><td style='text-align: center'>Noch keine Buchungen erstellt</td></tr>";
                            } else {
                                for ($i = 0; $i < (sizeof($service->accountings) > 5 ? 5 : sizeof($service->accountings)); $i++) {
                                    $color = getValueColor($service->accountings[sizeof($service->accountings) - ($i + 1)]->getIsPositive());
                                    echo "<tr><td style='width: 40%'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getDate() . "</td><td style='text-align: left'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getName() . "</td><td class='$color'>" . convertValue(abs($service->accountings[sizeof($service->accountings) - ($i + 1)]->getValue()), $service->accountings[sizeof($service->accountings) - ($i + 1)]->getIsPositive()) . "</td></tr>";
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
                                    echo "<tr><td style='width: 40%'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getDate() . "</td><td style='text-align: left'>" . $service->accountings[sizeof($service->accountings) - ($i + 1)]->getName() . "</td><td class='$color'>" . convertValue(abs($service->accountings[sizeof($service->accountings) - ($i + 1)]->getValue()), $service->accountings[sizeof($service->accountings) - ($i + 1)]->getIsPositive()) . "</td></tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <br/>

        <div class="row" style="margin: 0px;">

            <div class="conatiner col-lg-4" style="border: white 3px solid; padding: 0px; background-color: #212529; margin: auto;">
                <?php

                    $service->reloadAccountings($service->repo->getAccountingsByUser($service->user->getUserID()));
                    $day = round(abs($service->getCostsFromAll() /(float)$service->repo->getDaysTotalBetweenAccountings($service->user->getUserID())[0]["Days"]), 2);
                    $week = $day * 7;
                    $month = $week * 4;

                    echo "  <div class='row' style='margin: 10px;'>
                                <h3 class='col-lg-12' style='color: white; text-align: center;'>Durchschnittliche Ausgaben</h3>
                            </div>
                            <div class='row' style='margin: 10px;'>
                                <h2 class='col-lg-12' style='color: white; text-align: left;'>$day €/Tag</h2>
                            </div>
                            <div class='row' style='margin: 10px;'>
                                <h2 class='col-lg-12' style='color: white; text-align: center;'>$week €/Woche</h2>
                            </div>
                            <div class='row' style='margin: 10px;'>
                                <h2 class='col-lg-12'style='color: white; text-align: right;'>$month €/Monat</h2>
                            </div>";
                ?>
            </div>

            <div class="conatiner col-lg-4" style="border: white 3px solid; padding: 0px; background-color: #212529; margin: auto; height: 230px">
                <canvas id="chart" style="height: 250px;"></canvas>
            </div>
        </div>

    </body>

    <br/>
    <footer>
        <?php

        $startDate = new DateTime('first day of this month');
        $endDate = new DateTime('last day of this month');
        $service->reloadAccountings($service->repo->getAccountingsBetweenDates($service->user->getUserID(), $startDate->format("y-m-d"), $endDate->format("y-m-d")));
        $out = abs($service->getCostsFromAll());
        $in = $service->getIncomeFromAll();

        echo <<< chartjs
            <script type='text/javascript'>
                    var ctx = $('#chart');
                    var chart = new Chart(ctx, {

                    type: 'horizontalBar',
                    
                    data: {
                        datasets: [
                          {
                            label: 'Einnahmen diesen Monats',
                            backgroundColor: ['rgb(0,255,0)'],
                            data: [$in]
                          },{
                            label: 'Ausgaben diesen Monats',
                            backgroundColor: ['rgb(255,0,0)'],
                            data: [$out]
                          }]
                      },
                    options: {
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                }
                            }]
                        },

                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                top: 0,
                                bottom: 0,
                            }
                        }, 
                        legend: {
                            labels: {
                                fontColor: 'white',
                                fontFamily: 'Segoe UI',
                            }
                        }
                    }
                });</script>
chartjs;
        printFooter();
        ?>
    </footer>

</html>