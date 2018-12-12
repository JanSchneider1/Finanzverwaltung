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
            include __DIR__ . "/../ressources/util.php";
            include __DIR__ . "/../ressources/templates.php";
            $service = new ContentService('derflo@mail.de');
        ?>
    </head>
    <body>
        <!-- Header -->
        <?php printHeader()?>
        <!-- Background -->
        <div class="background">
            <!-- Title -->
            <br/>
            <h1 class="title">Kategorien</h1>
            <br/>

            <!-- Categories -->
            <div class="container">
                <table class="table table-dark table-hover">
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
                                    <td class="categoryName value">$name</td>
                                    <td style="text-align: end"><button class="btn btn-dark hvr-reveal" onclick="alterCategory($id)"><span class="fas fa-check"></span></button> <button class="btn btn-dark hvr-reveal" onclick="deleteCategory($id)"><span class="fas fa-trash-alt"></span></button></td>
                                </tr>
Category;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php printFooter(); ?>
        </div>

    </body>
</html>