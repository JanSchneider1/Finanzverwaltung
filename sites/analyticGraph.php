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

    <!-- LESS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>

    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>

    <?php
    $startDate = null;
    $endDate = null;

    //calculate the budget to begin of specified time to display
    $budget = 0;
    $service->reloadAccountings($service->repo->getAccountingsBeforeDate($service->user->getUserID(),$startDate));
    $service->orderAccountingsByDate();
    foreach($service->accountings as $accounting)
    {
        $budget += $accounting->getValue();
    };

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $startDate = htmlspecialchars($_POST['start_date']);
        $endDate = htmlspecialchars($_POST['end_date']);
        if($endDate < $startDate)
        {
            $endDate = $startDate;
        }
    }
    ?>
</head>
<header>
    <?php printHeader(); ?>
</header>
<body class="background">
<!-- Filter -->
<div class="container" style="padding-top: 20px">
    <table class="table table-hover table-dark">
        <thead>
        <tr>
            <th>Zeitraum</th>
            <th>Von</th>
            <th>Bis</th>
        </tr>
        </thead>
        <tbody>
        <td>
            <!-- Dropdown: Zeitraum -->
            <div class="dropdown">
                <button class="btn dropdown-toggle hvr-grow" type="button" value="Alle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    <?php echo $startDate != null ? "Eigen" : "Alle"; ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li id="month"><a class="dropdown-item effect-underline" data-value="Dieser Monat">Diesen Monat</a></li>
                    <li id="day"><a class="dropdown-item effect-underline" data-value="Heute">Heute</a></li>
                    <li id="week"><a class="dropdown-item effect-underline" data-value="Diese Woche">Diese Woche</a></li>
                    <li id="year"><a class="dropdown-item effect-underline" data-value="Dieses Jahr">Dieses Jahr</a></li>
                    <li id="own"><a class="dropdown-item effect-underline" data-value="Eigen">Eigen</a></li>
                </ul>
            </div>
        </td>
        <form method="post" action="analyticGraph.php">
            <td><input class="form-control input" id="date_1" name="start_date" value="<?php if ($startDate != null) {echo $startDate;} ?>" type="date"></td>
            <td><input class="form-control input" id="date_2" name="end_date" value="<?php if ($endDate != null) {echo $endDate;}?>" type="date"></td>
            <td style="text-align: end">
                <button class="btn hvr-underline-from-left" id="btn_filter" type="submit" style="width:100px">Filtern</button>
            </td>
        </form>
        </tbody>
    </table>
</div>
<div class="container table" style="text-align: center; padding-top: 10px;">
    <span>Budget over Time</span>
    <canvas id="outChart" style="min-height: 300px;"></canvas>
</div>
<footer>
<?php printFooter();
    $service->reloadAccountings($service->repo->getAccountingsBetweenDates($service->user->getUserID(),$startDate, $endDate));
    if($service->accountings != null)
    {
        $service->orderAccountingsByDate();
        $dates = array();
        $data = array();
        $zaehler = 0;
        $currentDate = $service->accountings[0]->getDate();
        $currentDateTotal = 0;
        foreach ($service->accountings as $accounting) {
            if ($currentDate != $accounting->getDate()) {
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
    }
    echo <<< ChartJS
    <script>
        var ctx = $('#outChart');
        var analyticLineGraph = new Chart(ctx,
        {
            type: 'line',
            data:
            {
                labels: [
ChartJS;

    //Filling labels[] with distinct dates of changes in budget
    if($service->accountings != null)
    {
        foreach ($dates as $dateEntry)
        {
            echo "'$dateEntry', ";
        }
    }

    echo
    "],
                datasets:
                [
                    {
                        
                        fill: false,
                        borderColor: 'rgb(255,255,255)',
                            data:
                                [";

    //Filling data[] with the specific date and the budget the user had that date, after calculating in all the accountings from that date
    if($service->accountings != null)
    {
        foreach ($data as $dataEntry)
        {
            echo $dataEntry;
        }
    }

    echo <<< ChartJS
                                ],
                       lineTension: 0
                    }
                ]
            },
            options:
            {
               legend:
               {
                    display: false
               }
            }
        }
        );
    </script>
ChartJS;
?>
    <script src="../js/timespanDropdown.js"></script>
    <script src="../js/frontend.js"></script>
</footer>
</body>
</html>
