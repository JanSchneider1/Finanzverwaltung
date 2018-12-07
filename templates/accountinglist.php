<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>PHP-Projekt</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  <!-- My stylesheets -->
  <link rel="stylesheet" href="../css/general.css">
  <link rel="stylesheet" href="../css/accounting.css">

  <!-- PHP Includes -->
    <?php
    include __DIR__ . "/../Php files/ContentService.php";
    include __DIR__ . "/../Php files/StringUtil.php";

    $service = new ContentService('derflo@mail.de');
    ?>

</head>
<body>

<!-- Header -->
<?php include __DIR__ . "/header.php"; ?>

<!-- Background -->
<div class="background">

  <!-- Title -->
  <h1 class="title">Ihre Finanzen</h1>
  <br/>

  <!-- Filter -->
  <div class="container">
    <table class="table table-dark table-hover">
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
          <button class="btn btn-dark dropdown-toggle" type="button" value="Alle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Alle
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="#" data-value="Alle">Alle</li>
            <li><a href="#" data-value="Dieses Jahr">Dieses Jahr</li>
            <li><a href="#" data-value="Diesen Monat">Diesen Monat</li>
            <li><a href="#" data-value="Diese Woche">Diese Woche</li>
            <li><a href="#" data-value="Heute">Heute</li>
          </ul>
        </div>
      </td>
      <td><input value="2018-01-01" type="date"></td>
      <td><input value="2018-01-01" type="date"></td>
      <td>
        <!-- Dropdown: 'Kategorien' -->
        <div class="dropdown">
          <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Kategorien
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <?php
              foreach ($service->categories as $c) {
                  $categoryName = $c->getName();
                  echo <<< Categories
                  <li><a href="#" data-value=$categoryName>$categoryName</li>
Categories;
              }
              ?>
          </ul>
        </div>
      </td>
      <td><!-- Empty --></td>
      <td><input type="number" step="0.01" value="0" style="width:100px"></td>
      <td><input type="number" step="0.01" value="0" style="width:100px"></td>
      <td><input class="btn btn-dark" value="Sortieren" style="width:100px"/></td>
      </tbody>
    </table>
  </div>
  <br/>

  <!--Bills-->
  <div class="container">
    <table class="table table-dark table-hover">
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
      function getValueColor($isPositive)
      {
          if ($isPositive == 1) {
              return "positive";
          } else {
              return "negative";
          }
      }

      foreach ($service->accountings as $a) {

          $id = $a->getAccountingID();
          $name = $a->getName();
          $date = $a->getDate();
          $category = $service->repo->getCategoryByID($a->getCategoryID())[0]["Name"];
          $value = convertValue($a->getValue(), $a->getIsPositive());
          $color = getValueColor($a->getIsPositive());

          echo <<< Accounting
        <tr id="$id">
          <td class="accountingDate">$date</td>
          <td class="accountingName">$name</td>
          <td class="accountingCategory">$category</td>
          <td class="accountingValue value $color">$value</td>
          <td style="text-align: end" class="accountingRemoveBt"><button onclick="deleteAccounting($id)" class="btn btn-dark"">X</button></td>
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
    <table class="table table-dark table-hover">
      <thead>
      <tr>
        <th>Einnahmen</th>
        <th>Kosten</th>
        <th>----> Differenz</th>
      </tr>
      </thead>
      <tbody>
      <tr>
          <?php
          $income = convertValue($service->getIncomeFromAll(), 1);
          $costs = convertValue($service->getCostsFromAll(), 0);

          $balance = 0;
          $temp_balance = $service->getBalanceFromAll();
          if ($temp_balance >= 0) {
              $balance = convertValue($temp_balance, 1);
          } else {
              $balance = convertValue($temp_balance, 0);
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
    <form>
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
          <td><input type=date value="2018-01-01" onsubmit="addAccounting()" name="addAccounting_date"></td>
          <td><input type="text" name="addAccounting_name"></td>
          <td>
            <fieldset>
              <!-- Dropdown: 'Kategorien' -->
              <div class="dropdown">
                <input class="input" style="display: none" value="/" type="text" name="addAccounting_categoryName">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Kategorien
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <?php
                    foreach ($service->categories as $c) {
                        $categoryName = $c->getName();
                        echo <<< Categories
                  <li><a href="#" data-value=$categoryName>$categoryName</li>
Categories;
                    }
                    ?>
                </ul>
              </div>
            </fieldset>
          </td>
          <td>
            <!-- Dropdown: -/+ -->
            <div class="dropdown">
              <input class="input" style="display: none" value="Ausgaben" type="text" name="addAccounting_isPositive">
              <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Ausgaben
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="#" data-value="Einnahmen">Einnahmen</li>
                <li><a href="#" data-value="Ausgaben">Ausgaben</li>
              </ul>
            </div>
          </td>
          <td><input type="number" name="addAccounting_value" step="0.01" value="0" style="width:100px"></td>
          <td><input class="btn btn-dark" onclick="addAccounting(this.form)" type="submit" value="Add"/></td>
        </tr>
        </tbody>
      </table>
    </form>
  </div>
  <!-- Footer -->
    <?php include __DIR__ . "/footer.php"; ?>

</div>

<!-- JS: Frontend utility -->
<script src="../js/frontend.js"></script>
<!-- JS: Accounting -->
<script src="../js/accounting.js"></script>

</body>
</html>