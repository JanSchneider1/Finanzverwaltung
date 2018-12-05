<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:th="http://www.thymeleaf.org">
<head>

  <title>PHP-Projekt</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <!--My stylesheet-->
  <link rel="stylesheet" href="../css/accounting.css">

</head>
<body>

<!-- Include Header -->
<div w3-include-html="header.html"></div>

<!--Background-->
<div id="background">
  <!--Header-->
  <div id="sectHeader" style='text-align:center;'>
    <!--Title-->
    <h1 style='color: white;'>Abrechnungen Oktober - November 2018</h1>
    <hr>
  </div>

  <!--Other referenced accountings-->
  <div id="sectOtherAccountings">
    <hr id="sectOtherAccountings_Hr_1">
  </div>

  <!--Bills-->
  <div id="sectBills">
    <div class="container">
      <table class="table table-dark table-hover">
        <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Category</th>
          <th>Value</th>
        </tr>
        </thead>
        <tbody id="list_bills">
        <!-- Add accountings to table -->
        <?php

        include __DIR__ . "/../Php files/ContentService.php";

        $service = new ContentService('derflo@mail.de');

        foreach ($service->accountings as $a){

            $name = $a->getName();
            $date = $a->getDate();
            $category = $a->getCategoryId();
            $value = $a->getValue();

            $isPositve = $a->getIsPositive();
            $color = "negative";
            if ($isPositve == 1) { $color = "positive"; }

            echo <<< Accounting
        <tr>
          <td class="accountingDate">$date</td>
          <td class="accountingName">$name</td>
          <td class="accountingCategory">$category</td>
          <td class="accountingValue $color">$value €</td>
          <td class="accountingRemoveBt"><button class="btn btn-dark" }">X</button></td>
        </tr>
Accounting;
        }
        ?>
        </tbody>
      </table>
    </div>
    <hr id="sectBills_Hr_1">
  </div>

  <!--Add new bills-->
  <div id="setcAddNewBills">
    <div class="container">
      <form th:action="@{/accountings/{id}(id=${accounting.id})}" onsubmit="return addNewBill(this);" method="POST">
        <table class="table table-dark table-hover">
          <thead>
          <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Tags</th>
            <th>Value</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><input id="addBillDate" value="2018-01-01" class="elementAddBill" type="date" name="billDate"></td>
            <td><input id="addBillDescription" class="elementAddBill" type="text" name="billDescription"></td>
            <td>
              <fieldset>
                <div th:if="${tags} != null" th:each="t : ${tags}">
                  <label><input type="checkbox" name="billTags" th:value="${t.name}"><span th:text="' ' + ${t.name}">ERROR: Displaying tag</span></label>
                </div>
              </fieldset>
            </td>
            <td><input id="addBillValue" class="elementAddBill" type="number" step="0.01" value="0"
                       name="billValue"><br></td>
            <td><input id="addBillButton" class="btn btn-dark" type="submit" value="Add"/></td>
          </tr>
          </tbody>
        </table>
      </form>
    </div>
    <hr id="sectAddNewBills_Hr_1">
  </div>

  <!--Balance-->
  <div id="sectBalance">
    <div class="container">
      <table class="table table-dark table-hover">
        <thead>
        <tr>
          <th>Income</th>
          <th>Costs</th>
          <th>----> Balance</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td class="account_Positive" th:if="${accounting.getIncome()} >= 0" th:text="${accounting.getIncome()}">ERROR:
            Displaying income
          </td>
          <td class="account_Negative" th:if="${accounting.getIncome()} < 0" th:text="${accounting.getIncome()}">ERROR:
            Displaying income
          </td>
          <td class="account_Positive" th:if="${accounting.getCosts()} >= 0" th:text="${accounting.getCosts()}">ERROR:
            Displaying costs
          </td>

        </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div w3-include-html="footer.html"></div>
<script src="../js/include.js"></script>
</body>
</html>