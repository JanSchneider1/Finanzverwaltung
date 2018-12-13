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
        <link rel="stylesheet" href="../css/general.css">
        <link rel="stylesheet" href="../css/hover-min.css">
        <?php
            include __DIR__ . "/../ressources/ContentService.php";
            include __DIR__ . "/../ressources/templates.php";
            include __DIR__ . "/../ressources/util.php";
            $service = new ContentService('derflo@mail.de');
        ?>
    </head>
    <body class="background">
        <!-- Header -->
        <?php printHeader() ?>
        <!-- Title -->
        <br/>
        <h1 class="title">Fixa</h1>
        <br/>

        <!-- Categories -->
        <div class="container">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Startdatum</th>
                            <th>Zuletzt</th>
                            <th>Name</th>
                            <th>Frequenz</th>
                            <th>Kategorie</th>
                            <th>Wert</th>
                        </tr>
                    </thead>
                    <tbody id="list_fixa">
                    <?php
                        foreach ($service->fixa as $f) {
                            $id = $f->getFixumID();
                            $startDate = $f->getStartDate();
                            $lastUsedDate = $f->getLastUsedDate();
                            $name = $f->getName();
                            $categoryName = 'Nicht zugeordnet';
                            $frequency;
                            $value = convertValue(abs($f->getValue()), ($f->getValue() < 0) ? 0 : 1);
                            $color = getValueColor(($f->getValue() < 0) ? 0 : 1);

                            if ($f->getCategoryID() != null) {
                                $categoryName = $service->repo->getCategoryByID($f->getCategoryID())[0]["Name"];
                            }

                            switch($f->getFrequency()){
                                case 'DAY':
                                    $frequency = 'Täglich';
                                    break;
                                case 'WEEK':
                                    $frequency = 'Wöchentlich';
                                    break;
                                case 'MONTH':
                                    $frequency = 'Monatlich';
                                    break;
                                case 'QUARTER':
                                    $frequency = 'Vierteljährlich';
                                    break;
                                case 'YEAR':
                                    $frequency = 'Jährlich';
                                    break;
                            }

                            echo <<< Fixum
                                    <tr id="$id">
                                        <th class="">$startDate</th>
                                        <th class="">$lastUsedDate</th>
                                        <th class="">$name</th>
                                        <th class="">$frequency</th>
                                        <th class="">$categoryName</th>
                                        <th class="$color">$value</th>
                                        <th style="text-align: end"><button class="btn btn-dark hvr-reveal" onclick="deleteFixum($id)"><span class="fas fa-trash-alt"></span></button></th>
                                    </tr>
Fixum;
                        }
                    ?>
                    </tbody>
                </table>
        </div>

        <div class="container">
                <table class="table table-dark table-hover">
                    <thead>
                    <tr>
                        <th>Startdatum</th>
                        <th>Name</th>
                        <th>Frequenz</th>
                        <th>Kategorie</th>
                        <th>+/-</th>
                        <th>Wert</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form method="POST" onsubmit="addFixum()">
                        <tr>
                            <th><input class="input-group form-control input" id="date" type=date value="" name="addFixum_date"></th>
                            <th class="value"><input class="input-group-text" style="background: #31343b; color: white;" type="text" name="addFixum_name"></th>
                            <th>
                                <fieldset>
                                    <!-- Dropdown: 'Frequenz' -->
                                    <div class="dropdown">
                                        <input class="input" style="display: none" value="0" type="text" name="addFixum_frequency">
                                        <button class="btn btn-dark dropdown-toggle hvr-grow" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Frequenz
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a class="dropdow-item effect-underline" data-value="DAY">Täglich</a></li>
                                            <li><a class="dropdow-item effect-underline" data-value="WEEK">Wöchentlich</a></li>
                                            <li><a class="dropdow-item effect-underline" data-value="MONTH">Monatlich</a></li>
                                            <li><a class="dropdow-item effect-underline" data-value="QUARTER">Vierteljährlich</a></li>
                                            <li><a class="dropdow-item effect-underline" data-value="YEAR">Jährlich</a></li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </th>
                            <th>
                                <fieldset>
                                    <!-- Dropdown: 'Kategorien' -->
                                    <div class="dropdown">
                                        <input class="input" style="display: none" value="0" type="text" name="addFixum_categoryID">
                                        <button class="btn btn-dark dropdown-toggle hvr-grow" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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
                            </th>
                            <th>
                                <!-- Dropdown: -/+ -->
                                <div class="dropdown">
                                    <input class="input" style="display: none" value="Ausgaben" type="text" name="addFixum_isPositive">
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
                            </th>
                            <th><input class="form-control input" type="number" name="addFixum_value" min="0.25" step="0.25" value="1" style="width:100px"></th>
                            <th style="text-align: end"><button type="button" class="btn btn-dark hvr-reveal" onclick="addFixum(this.form)"><span class="fas fa-check"></span></button></th>
                        </tr>
                    </form>
                    </tbody>
                </table>
        </div>
        <?php printFooter(); ?>
        <script src="../js/fixa.js"></script>
        <script src="../js/frontend.js"></script>
    </body>
</html>