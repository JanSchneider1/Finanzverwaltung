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
        ?>

    </head>
    <header>
        <?php printHeader(); ?>
    </header>
    <body>

        <div class="row" style="padding: 20px">

            <div class="col-lg-6">
                <div class="container table" style="text-align: center; padding-top: 10px;">
                    <span>Ausgaben</span>
                    <canvas id="outChart" style="min-height: 300px;"></canvas>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="container table" style="text-align: center; padding-top: 10px;">
                    <canvas id="inChart"></canvas>
                </div>
            </div>
        </div>
    </body>

    <footer>
        <?php printFooter();

        echo <<< chartjs
            <script type="text/javascript">
                var ctx = $('#outChart');
                var chart = new Chart(ctx, {

                    type: 'horizontalBar',

                    data: {
                        datasets: [{
                          label: 'Steam',
                          backgroundColor: ['rgb(255,99,71)'],
                          data: [208, 136, 6, 155]
                        }, {
                          label: 'Auto',
                          backgroundColor: ['rgb(255,140,0)'],
                          data: [136]
                        }, {
                          label: 'Essen',
                          backgroundColor: ['rgb(0,255,0)'],
                          data: [67]
                        }, {
                          label: 'Haushalt',
                          backgroundColor: ['rgb(24,116,205)'],
                          data: [155]
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
                                top: 20,
                                bottom: 0
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
        ?>

    </footer>
</html>