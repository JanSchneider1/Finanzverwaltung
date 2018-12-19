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

  <!-- PHP Includes -->
    <?php
    include __DIR__ . "/../ressources/ContentService.php";
    include __DIR__ . "/../ressources/util.php";
    include __DIR__ . "/../ressources/templates.php";
    $service = new ContentService('derflo@mail.de');
    ?>

</head>

<body>
<!-- Header -->
<?php printHeader(); ?>


<!-- Doughnut-Chart -->
<!-- Calculate margin-left : 50% - size(%) / 2 = x -->
<div style="width: 40%; margin-left: 30%; padding-top: 30px; padding-bottom: 30px">
  <canvas id="chart"></canvas>
</div>

<?php

$categories = $service->categories;

$names = array();
$balances = array();
$costs = array();
$income = array();

for($i = 0, $size = count($categories); $i < $size; ++$i) {

    //Get all accounting of category
    $accountingsOfCategory = $service->repo->getAccountingsByCategory($service->user->getUserID(), $categories[$i]->getId());
    //Get values --> Add to array
    $names[$i] = $categories[$i]->getName();
    $balances[$i] = $service->getBalance($accountingsOfCategory);
    $costs[$i] = $service->getCosts($accountingsOfCategory);
    $income[$i] = $service->getIncome($accountingsOfCategory);
}
var_dump($balances);
$data = toCharJSData($balances);
$labels = toCharJSLabels($names);
var_dump($data);

echo <<< chartjs2
  <script type="text/javascript">
  var chart = new Chart($('#chart'), { type: 'doughnut',
   data: {
      
      datasets: [{
        backgroundColor: ['rgb(51, 153, 51)', 'rgb(255, 80, 80)'],
        data: $data
      }],
      labels: $labels
    },  
  });
</script>
chartjs2;
?>

<!-- Doughnut-Chart -->
<!-- Calculate margin-left : 50% - size(%) / 2 = x -->
<div style="width: 40%; margin-left: 30%; padding-top: 30px; padding-bottom: 30px">
  <canvas id="chart2"></canvas>
</div>

<?php

$totalCosts = abs($service->getCostsFromAll());
$totalIncome = $service->getIncomeFromAll();

foreach ($service->categories as $c) {

    $categoryName = $c->getName();
    $categoryID = $c->getId();
    $accountingsOfCategory = $service->repo->getAccountingsByCategory($service->user->getUserID(), $categoryID);
}

echo <<< chartjs
<script type="text/javascript">
  var chart = new Chart($('#chart2'), { type: 'doughnut',
   data: {
      
      datasets: [{
        backgroundColor: ['rgb(51, 153, 51)', 'rgb(255, 80, 80)'],
        data: [$totalIncome,$totalCosts]
      }],

      // labels appear in the legend and in the tooltips when hovering different arcs
      labels: [
        'Einnahmen',
        'Ausgaben'
      ],
    },  
  });
</script>
chartjs;
?>

<!-- Footer -->
<?php printFooter(); ?>


</body>