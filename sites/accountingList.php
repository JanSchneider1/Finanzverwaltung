<?php
include __DIR__ . "/../ressources/ContentService.php";
include __DIR__ . "/../ressources/util.php";
include __DIR__ . "/../ressources/templates.php";
$service = new ContentService('derflo@mail.de');
session_start();
setRedirect();
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

  <!-- PHP Includes -->
    <?php
    $startDate = null;
    $endDate = null;
    $categoryID = null;
    $minValue = null;
    $maxValue = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $startDate = htmlspecialchars($_POST['start_date']);
        $endDate = htmlspecialchars($_POST['end_date']);
        $categoryID = htmlspecialchars($_POST['category_filter']);
        $minValue = htmlspecialchars($_POST['min_value']);
        $maxValue = htmlspecialchars($_POST['max_value']);

        if ($categoryID == 'Alle') {
            $service->reloadAccountings($service->repo->getAccountingsBetweenValuesBetweenDates($service->user->getUserID(), $minValue, $maxValue, $startDate, $endDate));
        } else {
            $service->reloadAccountings($service->repo->getAccountingsByCategoryBetweenValuesBetweenDates($service->user->getUserID(), $categoryID, $minValue, $maxValue, $startDate, $endDate));
        }
    }
    ?>

</head>
<body class="background">

<!-- Header -->
<?php printHeader(); ?>

<!-- Title -->
<br/>
<h1 class="title">Ihre Finanzen</h1>
<br/>

<!-- Filter -->
<div class="container">
  <table class="table table-hover table-dark">
    <thead>
    <tr>
      <th>Zeitraum</th>
      <th>Von</th>
      <th>Bis</th>
      <th>Kategorie</th>
      <th>Wert</th>
      <th>Von</th>
      <th>Bis</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <td>
      <!-- Dropdown: Zeitraum -->
      <div class="dropdown">
        <button class="btn dropdown-toggle hvr-grow" type="button" value="Alle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true">
            <?php echo $startDate != null ? "Eigen" : "Dieser Monat"; ?>
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
    <form method="post" action="accountingList.php">
      <td><input class="form-control input" id="date_1" name="start_date" value="<?php if ($startDate != null) {
              echo $startDate;
          } ?>" type="date"></td>
      <td><input class="form-control input" id="date_2" name="end_date" value="<?php if ($endDate != null) {
              echo $endDate;
          } ?>" type="date"></td>
      <td>
        <!-- Dropdown: 'Kategorien' -->
        <div class="dropdown">
          <input class="input" style="display: none" value="<?php echo $categoryID != null ? $categoryID : "Alle"; ?>"
                 type="text" name="category_filter">
          <button class="btn dropdown-toggle hvr-grow" type="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="true">
              <?php echo ($categoryID != "Alle" && $categoryID != null) ? $service->repo->getCategoryByID($categoryID)[0]['Name'] : "Alle"; ?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a class="dropdown-item effect-underline" data-value="Alle">Alle</a></li>
              <?php
              foreach ($service->categories as $c) {
                  $categoryName = $c->getName();
                  $categoryID = $c->getId();
                  echo "<li><a class=\"dropdown-item effect-underline\" data-value=$categoryID>$categoryName</a></li>";
              }
              ?>
            <li><a class="dropdown-item effect-underline" data-value="0"> Nicht zugeordnet</a></li>
          </ul>
        </div>
      </td>
      <td><!-- Empty --></td>
      <td><input class="form-control input" type="number" step="1" name="min_value"
                 value="<?php echo $minValue != null ? $minValue : $service->repo->getLowestAccountingValue($service->user->getUserID()) ?>"
                 style="width:100px"></td>
      <td><input class="form-control input" type="number" step="1" name="max_value"
                 value="<?php echo $maxValue != null ? $maxValue : $service->repo->getHighestAccountingValue($service->user->getUserID()) ?>"
                 style="width:100px"></td>
      <td>
        <button class="btn hvr-underline-from-left" id="btn_filter" type="submit" style="width:100px">Filtern</button>
      </td>
    </form>
    </tbody>
  </table>
</div>
<br/>

<!-- Accountings -->
<div class="container">
  <table class="table table-hover table-dark">
    <thead>
    <tr>
      <th>Datum</th>
      <th>Name</th>
      <th>Kategorie</th>
      <th>Wert</th>
    </tr>
    </thead>
    <tbody id="list_bills">
    <!-- Add accountings to table -->
    <?php
    foreach ($service->accountings as $a) {

        $id = $a->getAccountingID();
        $name = $a->getName();
        $date = $a->getDate();
        $category = 'Nicht zugeordnet';
        if ($a->getCategoryID() != null) {
            $category = $service->repo->getCategoryByID($a->getCategoryID())[0]["Name"];
        }
        $value = convertValue(abs($a->getValue()), $a->getIsPositive());
        $color = getValueColor($a->getIsPositive());

        echo <<< Accounting
                <tr id="$id">
                  <td class="accountingDate value">$date</td>
                  <td class="accountingName value">$name</td>
                  <td class="accountingCategory value">$category</td>
                  <td class="accountingValue value $color">$value</td>
                  <td style="text-align: end"><button onclick="deleteAccounting($id)" class="btn hvr-reveal"><span class="fas fa-trash-alt"></span></button></td>
                </tr>
Accounting;
    }
    ?>
    </tbody>
  </table>
</div>
<br/>

<!--Balance-->
<div class="container">
  <table class="table table-hover table-dark">
    <thead>
    <tr>
      <th>Einnahmen</th>
      <th>Kosten</th>
      <th>Differenz</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        $income = convertValue($service->getIncomeFromAll(), 1);
        $costs = convertValue(abs($service->getCostsFromAll()), 0);

        $balance = 0;
        $temp_balance = $service->getBalanceFromAll();
        if ($temp_balance >= 0) {
            $balance = convertValue($temp_balance, 1);
        } else {
            $balance = convertValue(abs($temp_balance), 0);
        }
        $color = "negative";
        if ($temp_balance >= 0) {
            $color = "positive";
        }

        echo <<< balance
                                    <td class="positive value">$income</td>
                                    <td class="negative value">$costs</td>
                                    <td class="$color value">$balance</td>
balance;
        ?>

    </tr>
    </tbody>
  </table>
</div>
<br/>

<!--Add accoutings-->
<div class="container">
  <form method="POST">
    <table class="table table-dark table-hover">
      <thead>
      <tr>
        <th>Datum</th>
        <th>Name</th>
        <th>Kategorien</th>
        <th>+/-</th>
        <th>Wert</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td><input class="form-control input" id="date_3" type=date value="" onsubmit="addAccounting()"
                   name="addAccounting_date"></td>
        <td><input class="form-control input-group-text input" type="text" name="addAccounting_name"></td>
        <td>
          <fieldset>
            <!-- Dropdown: 'Kategorien' -->
            <div class="dropdown">
              <input class="input" style="display: none" value="0" type="text"
                     name="addAccounting_categoryID">
              <button class="btn btn-dark dropdown-toggle hvr-grow" type="button" id="dropdownMenu2"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Kategorien
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <?php
                  foreach ($service->categories as $c) {
                      $categoryName = $c->getName();
                      $categoryID = $c->getId();
                      echo "<li><a class=\"dropdown-item effect-underline\" data-value=$categoryID>$categoryName</a></li>";
                  }
                  ?>
              </ul>
            </div>
          </fieldset>
        </td>
        <td>
          <!-- Dropdown: -/+ -->
          <div class="dropdown">
            <input class="input" style="display: none" value="Ausgaben" type="text"
                   name="addAccounting_isPositive">
            <button class="btn btn-dark dropdown-toggle hvr-grow" type="button" id="dropdownMenu2"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Ausgaben
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <li><a class="dropdown-item effect-underline" data-value="Einnahmen">Einnahmen</a></li>
              <li><a class="dropdown-item effect-underline" data-value="Ausgaben">Ausgaben</a></li>
            </ul>
          </div>
        </td>
        <td><input class="form-control input" type="number" name="addAccounting_value" min="0.25" step="0.25" value="1"
                   style="width:100px"></td>
        <td>
          <button type="button" class="btn btn-dark hvr-reveal" onclick="addAccounting(this.form)"><span
                class="fas fa-check"></span></button>
        </td>
      </tr>
      </tbody>
    </table>
  </form>
</div>
<!-- Footer -->
<?php printFooter(); ?>

<!-- JS: Frontend utility -->
<script src="../js/frontend.js"></script>
<!-- JS: Accounting -->
<script src="../js/accounting.js"></script>
<?php echo $startDate == null ? '<script language="JavaScript">setDatesMonth()</script>' : '<script language="JavaScript">enableDates()</script>'; ?>
<!-- Set dates to current -->
<script language="JavaScript">document.getElementById("date_3").valueAsDate = new Date();</script>

<!-- Footer -->
<?php printFooter(); ?>

<!-- JS: Frontend utility -->
<script src="../js/frontend.js"></script>

<!-- JS: Accounting -->
<script src="../js/accounting.js"></script>
<script src="../js/timespanDropdown.js"></script>

<!-- Set dates -->
<?php echo $startDate == null ? '<script language="JavaScript">setDatesMonth()</script>' : '<script language="JavaScript">enableDates()</script>'; ?>

<!-- Set dates to current -->
<script language="JavaScript">document.getElementById("date_3").valueAsDate = new Date();</script>

</body>
</html>
