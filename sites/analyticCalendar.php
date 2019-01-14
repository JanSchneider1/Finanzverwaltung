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

        <?php
        $startDate = new DateTime("first day of this month");
        $lastDate = new DateTime("last day of this month");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $startDate = new DateTime($_POST['start_date']);
            $lastDate = new DateTime($_POST['end_date']);
        }

        $sd1 = clone $sd2 = clone $startDate;
        $ld1 = clone $ld2 = clone $lastDate;

        ?>

    </head>

    <header>
        <?php printHeader(); ?>
    </header>

    <body>

    <!-- Filter -->
    <div class="container row" style=" background-color: #212529; margin: auto; margin-top: 20px; padding-top: 20px; width: 30%;">

        <form class="col-lg-2" action="analyticCalendar.php" method="post" id="last">
            <input type="hidden" name="start_date" value="<?php echo $sd1->modify("first day of previous month")->format("y-m-d"); ?>">
            <input type="hidden" name="end_date" value="<?php echo $ld1->modify("last day of previous month")->format("y-m-d"); ?>">
            <div style="text-align: left;">
                <button class="btn btn-dark" onclick="$('#last').submit()"><span class="fa fa-caret-left"></span></button>
            </div>
        </form>
            <div class="col-lg-8" style="text-align: center; color: white;">
                <h2>
                    <?php

                    switch ($startDate->format('m')){
                        case 1:
                            echo "Januar";
                            break;
                        case 2:
                            echo "Februar";
                            break;
                        case 3:
                            echo "März";
                            break;
                        case 4:
                            echo "April";
                            break;
                        case 5:
                            echo "Mai";
                            break;
                        case 6:
                            echo "Juni";
                            break;
                        case 7:
                            echo "Juli";
                            break;
                        case 8:
                            echo "August";
                            break;
                        case 9:
                            echo "September";
                            break;
                        case 10:
                            echo "Oktober";
                            break;
                        case 11:
                            echo "November";
                            break;
                        case 12:
                            echo "Dezember";
                            break;
                    }
                        echo " " . $startDate->format("Y");
                    ?>
                </h2>
            </div>
        <form class="col-lg-2" action="analyticCalendar.php" method="post" id="next" >
            <input type="hidden" name="start_date" value="<?php echo $sd2->modify("first day of next month")->format("y-m-d"); ?>">
            <input type="hidden" name="end_date" value="<?php echo $ld2->modify("last day of next month")->format("y-m-d"); ?>">
            <div style="text-align: right;">
                <button class="btn btn-dark"><span class="fa fa-caret-right" onclick="$('#next').submit()"></span></button>
            </div>
        </form>
    </div>


    <div>
        <div class="container" style="text-align: center; padding: 5px; background-color: #212529; color: black;">

            <table class="table table-hover table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Mo</th>
                        <th>Di</th>
                        <th>Mi</th>
                        <th>Do</th>
                        <th>Fr</th>
                        <th>Sa</th>
                        <th>So</th>
                    </tr>
                </thead>
                <tbody style="color: black; font-size: 30px;">
                    <?php

                        $costs = array();
                        $sum = 0;
                        $colors = [
                                0 => "#31343b",
                                1 => "#008000",
                                2 => "#8bc000",
                                3 => "#ffec00",
                                4 => "#e59a00",
                                5 => "#e53e00",
                        ];

                        $color;
                        $first = $startDate->format("w");
                        $last = $lastDate->format('d');
                        $now = new DateTime();

                        for($i = clone $startDate; $i <= $lastDate; $i->modify("+1 day")){
                            $service->reloadAccountings($service->repo->getAccountingsBetweenDates($service->user->getUserID(),$i->format("Y-m-d"),$i->format("Y-m-d")));
                            array_push($costs, abs($service->getCostsFromAll()));
                            $sum += abs($service->getCostsFromAll());
                        }
                        @$percent = 100 / $sum;
                        for($i = 0; $i < 42; $i++){
                            $color = 1;

                            if($i % 7 == 0){
                                echo "<tr style='height: 70px;'>";
                            }
                            if($i + 1 < $first || $i > $last){
                                echo "<td style='background-color: $colors[0]'></td>";
                            }
                            else{
                                if($costs[$i - ($first -1)] != 0){
                                    $percentage = $costs[$i - $first + 1] * $percent;
                                    for($x = 20; $x < 100; $x += 20){
                                        if($percentage < $x){
                                            break;
                                        }
                                        $color++;
                                    }
                                } else{
                                    $color = 1;
                                }
                                echo "<td style='background-color: $colors[$color]; border: lightgray 2px solid; z-index: 10;'>";
                                echo ($costs[$i - $first + 1] != 0 ? ("- ".$costs[$i - $first + 1]." €") : "")."</td>";
                            }

                            if($i % 7 == 6){
                                echo "</tr>";
                            }
                        }
                    ?>
            </table>

        </div>
    </div>

    </body>
    <footer>
        <?php printFooter(); ?>
    </footer>
</html>