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
<!DOCTYPE html>
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

    !-- LESS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>

    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
</head>
<body>
<header>
<?php printHeader(); ?>
</header>
    <div style="color:white">
        <canvas id='analyticGraphCanvas'></canvas>
    </div>
<footer>
<?php printFooter();
    $startDate = '2019-01-10';
    $endDate = '2019-12-12';
    $unit = 'day';
    //calculate the budget to begin of specified time to display
    $budget = 0;
    $service->reloadAccountings($service->repo->getAccountingsBeforeDate($service->user->getUserID(),$startDate));
    foreach($service->accountings as $accounting)
    {
            $budget += $accounting->getValue();
    };
    $service->reloadAccountings($service->repo->getAccountingsBetweenDates(1,$startDate, $endDate));
    $dates = array();
    $data = array();
    $zaehler = 0;
    $currentDate = $service->accountings[0]->getDate();
    $currentDateTotal = 0;
    foreach($service->accountings as $accounting)
    {
        if($currentDate != $accounting->getDate())
        {
            $dates[$zaehler] = $currentDate;
            $budget += $currentDateTotal;
            $data[$zaehler] = "{x: $currentDate, y: $budget},";
            $currentDate = $accounting->getDate();
            $currentDateTotal = 0;
            ++$zaehler;
        }
        $currentDateTotal += $accounting->getValue();
    }
    $dates[$zaehler] = $currentDate;
    $budget += $currentDateTotal;
    $data[$zaehler] = "{x: $currentDate, y: $budget},";

echo <<< ChartJS
    <script>
        var ctx = document.getElementById('analyticGraphCanvas').getContext('2d');
        var analyticLineGraph = new Chart(ctx,
        {
            type: 'line',
            data:
            {
                labels: [
ChartJS;

    //Filling labels[] with distinct dates of changes in budget
    foreach($dates as $dateEntry)
    {
        echo "'$dateEntry', ";
    }


    echo
    "],
                datasets:
                [
                    {
                        label: 'Budget over time',
                        fill: false,
                        borderColor: 'rgb(255,255,255)',
                            data:
                                [";

    //Filling data[] with the specific date and the budget the user had that date, after calculating in all the accountings from that date
    foreach($data as $dataEntry)
    {
        echo $dataEntry;
    }

    echo <<< ChartJS
                                ],
                       lineTension: 0
                    }
                ]
            },
            options:
            {
               
            }
        }
        );
    </script>
ChartJS;
?>
</footer>
</body>
</html>
