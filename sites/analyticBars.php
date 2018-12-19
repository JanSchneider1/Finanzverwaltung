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
            include __DIR__ . "/../ressources/ContentService.php";
            include __DIR__ . "/../ressources/util.php";
            include __DIR__ . "/../ressources/templates.php";
            $service = new ContentService('derflo@mail.de');
            $startDate = null;
            $endDate = null;


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $startDate = htmlspecialchars($_POST['start_date']);
                $endDate = htmlspecialchars($_POST['end_date']);
                $service->reloadAccountings($service->repo->getAccountingsBetweenDates($service->user->getUserID(), $startDate, $endDate));
            }
        ?>

    </head>
    <header>
        <?php printHeader(); ?>
    </header>
    <body>

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
                <form method="post" action="analyticBars.php">
                    <td><input class="form-control input" id="date_1" name="start_date" value="<?php if ($startDate != null) {echo $startDate;} ?>" type="date"></td>
                    <td><input class="form-control input" id="date_2" name="end_date" value="<?php if ($endDate != null) {echo $endDate;} ?>" type="date"></td>
                    <td style="text-align: end">
                        <button class="btn hvr-underline-from-left" id="btn_filter" type="submit" style="width:100px">Filtern</button>
                    </td>
                </form>
                </tbody>
            </table>
        </div>

        <div>
            <div class="container table" style="text-align: center; padding-top: 10px;">
                <span>Ausgaben</span>
                <canvas id="outChart" style="min-height: 300px;"></canvas>
            </div>
        </div>

    </body>

    <footer>
    <script type='text/javascript'>
                var ctx = $('#outChart');
                var chart = new Chart(ctx, {

                    type: 'horizontalBar',

                    data: {
                        datasets: [
        <?php

            $values = array();

            for($i = 0; $i < sizeof($service->accountings); $i++) {

                @$values[$service->accountings[$i]->getCategoryID()] += $service->accountings[$i]->getValue();
            }



        for($i = 0; $i < sizeof($service->accountings); $i++) {

            if($values[$i] != null){
                $catName = $service->repo->getCategoryByID($i)['Name'];

                echo "{
                        label: $catName,
                        backgroundColor: ['rgb(255,99,71)'],
                        data: [$values[$i]]
                      },";
            }
        }
        echo <<< chartjs
                        ]
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
                                top: 20,
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
                });
            </script>
chartjs;
            printFooter();
        ?>
        <script src="../js/timespanDropdown.js"></script>
        <script src="../js/frontend.js"></script>

    </footer>

</html>