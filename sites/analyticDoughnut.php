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

  <!-- Get the LESS color attribute -->
  <span id="backgroundColor" class="background" style="background-color: #17191c"></span>

  <!-- LESS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>

  <!-- ChartJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

  <!-- Color-Generator -->
  <script src="../js/colorgenerator.js"></script>

  <!-- PHP Includes -->
    <?php
    $categories = $service->categories;
    //Add 'Nicht-Zugeordnet' to category list
    $categories[count($categories)] = new Category(0, "Nicht-Zugeordnet");
    ?>

</head>
<body class="background">

<!-- Analytics JS -->

<!-- Header -->
<?php printHeader(); ?>

<?php

$labels = array();
$balances = array();
$costs = array();
$income = array();
$colorsNegative = array();
$colorsPositive = array();
$accountingNames = array();
$accountingValues = array();

for($i = 0, $size = count($categories); $i < $size; ++$i) {

    //Get all accounting of category --> saved now in $accountings
    $service->reloadAccountings($service->repo->getAccountingsByCategory($service->user->getUserID(), $categories[$i]->getId()));
    //Get values --> Add to array
    $names[$i] = $categories[$i]->getName();
    $balances[$i] = $service->getBalanceFromAll();
    $costs[$i] = abs($service->getCostsFromAll());
    $income[$i] = $service->getIncomeFromAll();
    $colorsPositive[$i] = "rgb(51, 153, 51)";
    $colorsNegative[$i] = "rgb(255, 80, 80)";
}

$income = toCharJSData($income);
$costs = toCharJSData($costs);
$labels = toCharJSLabels($names);
$colorsNegative = toCharJSLabels($colorsNegative);
$colorsPositive = toCharJSLabels($colorsPositive);


$service->reloadAccountings($service->repo->getAccountingsByUser($service->user->getUserID()));

$totalCosts = abs($service->getCostsFromAll());
$totalIncome = $service->getIncomeFromAll();

echo <<< cache
<script>
  var income = $income;
  var costs = $costs;
  var labels = $labels;
  var colorsNegative = $colorsNegative;
  var colorsPositive = $colorsPositive;
  var totalCosts = $totalCosts;
  var totalIncome = $totalIncome;
</script>
cache;
?>

<!-- Chart-Container -->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6">
      <!-- Calculate margin-left : 50% - size(%) / 2 = x -->
      <div style="width: 80%; margin-left: 10%; padding-top: 30px; padding-bottom: 30px; text-align: center">
        <div class="dropdown">
        <button class="btn dropdown-toggle hvr-grow" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="true" style="font-size: 25px">
          <span class="caret">Einnahmen</span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <li><a class="dropdown-item effect-underline" style="color: white" onclick="recreateDoughnut('chart', income, labels, colorsPositive)">Einnahmen</a></li>
          <li><a class="dropdown-item effect-underline" style="color: white" onclick="recreateDoughnut('chart', costs, labels, colorsNegative)">Ausgaben</a></li>
        </ul>
      </div>
        <!-- Doughnut-Chart -->
        <canvas id="chart"></canvas>
      </div>
    </div>
    <div class="col-sm-6">
      <!-- Calculate margin-left : 50% - size(%) / 2 = x -->
      <div style="width: 80%; margin-left: 10%; padding-top: 30px; padding-bottom: 30px; text-align: center">
        <div class="dropdown">
          <button class="btn dropdown-toggle hvr-grow" type="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="true" style="font-size: 25px">
            <span class="caret">Gesamt</span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <?php
              for($i = 0, $size = count($categories); $i < $size; ++$i) {

                  $categoryName = $categories[$i]->getName();
                  $categoryID = $categories[$i]->getId();
                  echo <<< category
<li><a class="dropdown-item effect-underline" style="color: white" 
onclick="recreateDoughnut('chartBalance', [income[$i], costs[$i]], ['Einnahmen','Ausgaben'], ['rgb(51, 153, 51)', 'rgb(255, 80, 80)']);">
$categoryName</a></li>
category;
              }
              echo <<< category2
<li><a class="dropdown-item effect-underline" style="color: white" 
onclick="recreateDoughnut('chartBalance', [totalIncome, totalCosts], ['Einnahmen','Ausgaben'], ['rgb(51, 153, 51)', 'rgb(255, 80, 80)']);">
Gesamt</a></li>
category2;
              ?>
          </ul>
        </div>
        <!-- Doughnut-Chart -->
        <canvas id="chartBalance"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php printFooter(); ?>

<!-- Analytics JS -->
<script src="../js/frontend.js"></script>

<script src="../js/analytic.js"></script>
<!-- Create charts on start -->
<script>
    doughnut("chart",income,labels,colorsPositive);
    doughnut("chartBalance",
        [totalIncome, totalCosts], ['Einnahmen','Ausgaben'], ['rgb(51, 153, 51)', 'rgb(255, 80, 80)']
    );
</script>

</body>
</html>
