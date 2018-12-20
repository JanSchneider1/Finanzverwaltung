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
        <!-- glyphicons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css">

  <!-- My stylesheets -->
  <link rel="stylesheet" href="../css/general.less">
  <link rel="stylesheet" href="../css/assets/hover-min.css">
  <link rel="stylesheet/less" type="text/css" href="../css/general.less">

  <!-- LESS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
</head>
<body class="background">
<!-- Header -->
<?php printHeader() ?>
<!-- Title -->
<br/>
<h1 class="title">Kategorien</h1>
<br/>

<!-- Categories -->
<div class="container">
  <div class="row">
    <div class="col-lg-4"></div>
    <table class="table table-dark table-hover col-lg-4">
      <thead>
      <tr>
        <th>Name</th>
      </tr>
      </thead>
      <tbody id="list_categories">
      <?php
      foreach ($service->categories as $c) {
          $id = $c->getID();
          $name = $c->getName();

          echo <<< Category
                        <tr id="$id">
                            <th class="value"><input class="input-group-text" style="background: #31343b; color: white;" id="category_$id" type="text" value="$name"></th>
                            <th style="text-align: end"><button class="btn btn-dark hvr-reveal" onclick="updateCategory($id)"><span class="fas fa-check"></span></button> <button class="btn btn-dark hvr-reveal" onclick="deleteCategory($id)"><span class="fas fa-trash-alt"></span></button></th>
                        </tr>
Category;
      }
      ?>
      </tbody>
    </table>
  </div>
</div>

        <div class="container">
            <div class="row">
                <div class="col-lg-4"></div>
                <table class="table table-dark table-hover col-lg-4">
                    <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form method="POST">
                        <tr>
                            <th class="value"><input class="input-group-text" style="background: #31343b; color: white;" type="text" name="addCategory_name"></th>
                            <th style="text-align: end"><button type="button" class="btn btn-dark hvr-reveal" onclick="addCategory(this.form)"><span class="fas fa-check"></span></button></th>
                        </tr>
                    </form>
                    </tbody>
                </table>
            </div>
        </div>
        <?php printFooter(); ?>
        <script src="../js/category.js"></script>
    </body>
</html>