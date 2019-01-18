<?php
/**
 * Created by PhpStorm.
 * User: Niklas
 * Date: 11.01.2019
 * Time: 18:52
 */
include __DIR__ . "/../ressources/templates.php";
include __DIR__ . "/../ressources/ContentService.php";

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

    <script src="../js/timespanDropdown.js"></script>


    <?php
        $startDate = null;
        $endDate = null;
        $mode ='';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $startDate = htmlspecialchars($_POST['start_date']);
            $endDate = htmlspecialchars($_POST['end_date']);
            if($endDate < $startDate)
            {
                $endDate = $startDate;
            }
            $mode = htmlspecialchars($_POST['mode']);
        }

        //calculate the budget to begin of specified time to display
        $budget = 0;
        $service->reloadAccountings($service->repo->getAccountingsBeforeDate($service->user->getUserID(),$startDate));
        $service->orderAccountingsByDate();
        foreach($service->accountings as $accounting)
        {
            $budget += $accounting->getValue();
        };
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
            <th>Modus</th>
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
<!--                    <li id="dayGraph"><a class="dropdown-item effect-underline" data-value="Heute">Heute</a></li>-->
                    <li id="week"><a class="dropdown-item effect-underline" data-value="Diese Woche">Diese Woche</a></li>
                    <li id="year"><a class="dropdown-item effect-underline" data-value="Dieses Jahr">Dieses Jahr</a></li>
                    <li id="own"><a class="dropdown-item effect-underline" data-value="Eigen">Eigen</a></li>
                </ul>
            </div>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn dropdown-toggle hvr-grow" type="button" value="Alle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    <?php
                    switch($mode)
                    {
                        case 'budget':  echo "Budget";
                            break;
                        case 'einnahmen':   echo "Einnahmen";
                            break;
                        case 'ausgaben':    echo "Ausgaben";
                            break;
                        default:    echo "Budget";
                            break;
                    }
                    ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li id="budgetMode"><a class="dropdown-item effect-underline" data-value="budget">Budget</a></li>
                    <li id="einnahmenMode"><a class="dropdown-item effect-underline" data-value="einnahmen">Einnahmen</a></li>
                    <li id="ausgabenMode"><a class="dropdown-item effect-underline" data-value="ausgaben">Ausgaben</a></li>
                </ul>
            </div>
        </td>
        <form method="post" action="analyticGraph.php">
            <td><input class="form-control input" id="date_1" name="start_date" value="<?php if ($startDate != null) {echo $startDate;} ?>" type="date"></td>
            <td><input class="form-control input" id="date_2" name="end_date" value="<?php if ($endDate != null) {echo $endDate;}?>" type="date"></td>
            <td><input id="mode" name="mode" value='budget' type="hidden"></td>
            <td style="text-align: end">
                <button class="btn hvr-underline-from-left" id="btn_filter" type="submit" style="width:100px">Filtern</button>
            </td>
        </form>

        </tbody>
    </table>
</div>
<div class="container table" style="text-align: center; padding-top: 10px;">
    <span>
        <?php
            switch($mode)
            {
                case 'budget':  echo "Budget";
                    break;
                case 'einnahmen':   echo "Einnahmen";
                    break;
                case 'ausgaben':    echo "Ausgaben";
                    break;
                default:    echo "Budget";
                    break;
            }
        ?>
    </span>
    <canvas id="outChart" style="min-height: 300px;"></canvas>
</div>
<script>setDatesMonth()</script>
<footer>
<?php printFooter();


    $service->reloadAccountings($service->repo->getAccountingsBetweenDates($service->user->getUserID(),$startDate, $endDate));
    if($service->accountings != null)
    {
        $einnahmen=0;
        $ausgaben=0;
        $service->orderAccountingsByDate();
        $dates = array();
        $data = array();
        $zaehler = 0;
        $currentDate = $service->accountings[0]->getDate();
        $currentDateTotal = 0;
        $currentDateEinnahmen = 0;
        $currentDateAusgaben = 0;

        foreach ($service->accountings as $accounting) {
            if ($currentDate != $accounting->getDate()) {
                $dates[$zaehler] = $currentDate;
                $budget += $currentDateTotal;
                $einnahmen += $currentDateEinnahmen;
                $ausgaben += $currentDateAusgaben;
                switch($mode){
                    case 'budget':      $data[$zaehler] = "{x: $currentDate, y: $budget},";
                        break;
                    case 'ausgaben':    $absAusgaben = abs($ausgaben);
                                        $data[$zaehler] = "{x: $currentDate, y: $absAusgaben},";
                        break;
                    case 'einnahmen':   $data[$zaehler] = "{x: $currentDate, y: $einnahmen},";
                        break;
                    default:            break;
                }
                $currentDate = $accounting->getDate();
                $currentDateTotal = 0;
                $einnahmen = 0;
                $ausgaben = 0;
                $currentDateEinnahmen = 0;
                $currentDateAusgaben = 0;
                ++$zaehler;
            }
            $currentDateTotal += $accounting->getValue();
            if($accounting->getIsPositive() == 1)
            {
                $currentDateEinnahmen +=  $accounting->getValue();
            }
            else
            {
                $currentDateAusgaben += $accounting->getValue();
            }
        }
        $dates[$zaehler] = $currentDate;
        $budget += $currentDateTotal;
        $einnahmen += $currentDateEinnahmen;
        $ausgaben += $currentDateAusgaben;
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
    <script>
        $("#budgetMode").click(function()
        {
            $("#mode").val('budget');
        });
        $("#einnahmenMode").click(function()
        {
            $("#mode").val('einnahmen');
        });
        $("#ausgabenMode").click(function()
        {
            $("#mode").val('ausgaben');
        });
    </script>
</footer>
</body>
</html>
