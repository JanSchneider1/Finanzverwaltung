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
include __DIR__ . "/../ressources/util.php";

session_start();
setRedirect();
$service = new ContentService($_SESSION["email"]);
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
    <div style="color:white">
        <canvas id='analyticGraphCanvas'></canvas>
    </div>
</body>
<footer>
    <?php printFooter();
    echo <<< ChartJS
    <script>
        var ctx = document.getElementById('analyticGraphCanvas').getContext('2d');
        var analyticLineGraph = new Chart(ctx,
        {
            type: 'line',
            data:
            {
                labels: ['2017 - 11 - 01', '2017 - 12 - 01', '2018 - 01 - 01', '2018 - 02 - 01', '2018 - 03 - 01'],
                datasets:
                [
                    {
                        label: 'Budget over time',
                        fill: false,
                        borderColor: 'rgb(255,255,255)',
                            data:
                                [
ChartJS;

    $startDate = '2019-01-10';
    $endDate = '2019-01-13';
    //calculate the budget to begin of specified time to display
        $budget = 0;
        $service->reloadAccountings($service->repo->getAccountingsBeforeDate($service->user->getUserID(),$endDate));
        foreach($service->accountings as $accounting)
        {
            if($accounting->getIsPositive() == 1) {
                $budget += $accounting->getValue();
            }
            else
            {
                $budget -= $accounting->getValue();
            }
        };

        //create the data to bei inserted into the graph by getting the date of the accounting and the budget after the accounting was added
        $service->reloadAccountings($service->repo->getAccountingsBetweenDates(1,$startDate, $endDate));
        foreach($service->accountings as $accounting)
        {
            $date = $accounting->getDate();
            //
            if($accounting->getIsPositive() == 1) {
                $budget += $accounting->getValue();
            }
            else
            {
                $budget -= $accounting->getValue();
            }
            //
            echo "{x: $date, y: $budget},";
        }

    echo <<< ChartJS
                                ],
                       lineTension: 0
                    }
                ]
            },
            options:
            {
                scales:
                {
                    xAxes:
                    [
                        {

                            type: 'time',
                            time:
                            {
                                unit: 'month'
                            }
                        }
                    ],
                    yAxes:
                    [
                            {
                                type: 'linear',
                                ticks:
                                {
                                    beginAtZero: true
                                }
                            }
                    ]
                }
            }
        }
        );
    </script>

ChartJS;

    ?>
</footer>
</html>
