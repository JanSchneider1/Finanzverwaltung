<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 15.01.2019
 * Time: 10:35
 */

session_start();
include __dir__ . "/../ressources/templates.php";
include __dir__ . "/../ressources/Repository.php";
$repository = new Repository();
$repository->init();
setRedirect();
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <!-- My stylesheets -->
    <link rel="stylesheet" href="../css/assets/texteffects.css">
    <link rel="stylesheet" href="../css/assets/hover-min.css">
    <link rel="stylesheet/less" type="text/css" href="../css/general.less">
    <link rel="stylesheet" href="../css/footer.css">

    <!-- LESS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
    <!-- Glyphicons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css">

    <title>FAQ</title>
    <script type="text/javascript" src="../js/form.js"></script>

    <style>
        img{border: white 1px solid;}
    </style>
</head>

<body class="background">
<?php printheader(); ?>
<div id="accordion" style="padding: 9%;">
    <div class="card" style="background-color: #212529;">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                    Wie erstelle ich eine Transaktion?
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body" style="color: white;">

                <p>
                <div class="text-center">
                    <img src="../pictures/Buchungen.png" class="img-fluid" alt="Responsive image">
                </div>
                <div class="text-center">
                    Um eine Transaktion zu erstellen navigieren und klicken Sie auf diesen Punkt.
                </div>
                </p>

                <hr>

                <p>
                <div class="text-center">
                    <img src="../pictures/Buchungenformular.png" class="img-fluid" alt="Responsive image">
                </div>
                <div class="text-center">
                    Danach scrollen Sie runter bis zum Formular. Dieses füllen Sie aus. Es wird ein Datum, ein Name,
                    eine Kategorie, die Art der Buchung und ein entsprechender Wert benötigt. Mit dem Haken bestätigen
                    Sie die Transaktion.
                </div>
                </p>

                <hr>

                <p>
                <div class="text-center">
                    <img src="../pictures/Buchungenliste.png" class="img-fluid" alt="Responsive image">
                </div>
                <div class="text-center">
                    Nun werde alle Ihre Transaktionen als Liste angezeigt, diese können über den Mülleimer wieder
                    entfernt werden.
                </div>
                </p>

                <hr>

                <p>
                <div class="text-center">
                    <img src="../pictures/Buchungenübersicht.png" class="img-fluid" alt="Responsive image">
                </div>
                <div class="text-center">
                    Hier sehen Sie eine kleine Übersicht über Ihre Einnahmen sowie Ausgaben und dessen Differenz.
                </div>
                </p>

            </div>
        </div>
        <div class="card" style="background-color: #212529;">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                        Wie erstelle ich eine Kategorie?
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body" style="color: white;">

                    <p>
                    <div class="text-center">
                        <img src="../pictures/Kategorien.png" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="text-center">
                        Um Kategorien zu erstellen navigieren und klicken Sie auf den Punkt Kategorien.
                    </div>
                    </p>
                    <hr>
                    <p>
                    <div class="text-center">
                        <img src="../pictures/Kategorienformular.png" class="img-fluid" alt="Haha">
                    </div>
                    <div class="text-center">
                        Danach scrollen Sie runter bis zum Formular und geben den Namen der Kategorie ein. Mit dem Haken
                        bestätigen Sie Ihre Eingabe.
                    </div>
                    </p>

                    <hr>
                    <p>
                    <div class="text-center">
                        <img src="../pictures/Kategorienliste.png" class="img-fluid" alt="Haha">
                    </div>
                    <div class="text-center">
                        Nun sehen Sie Ihre Liste von Kategorien, diese können bearbeitet oder gelöscht werden. Wenn Sie
                        den Namen ändern müssen Sie diesen wieder mit dem Haken bestätigen, mit dem Mülleimer entfernen
                        Sie die gewählte Kategorie.
                    </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="card" style="background-color: #212529;">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree">
                        Wie erstelle ich einen Dauerauftrag?
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body" style="color: white;">
                    <p>
                    <div class="text-center">
                        <img src="../pictures/Fixa.png" class="img-fluid" alt="Haha">
                    </div>
                    <div class="text-center">
                        Um einen Dauerauftrag zu erstellen navigieren und klicken Sie auf diesen Punkt.
                    </div>
                    </p>
                    <hr>
                    <p>
                    <div class="text-center">
                        <img src="../pictures/Fixaformular.png" class="img-fluid" alt="Haha">
                    </div>
                    <div class="text-center">
                        Danach scrollen Sie runter bis zum Formular und geben dem Dauertauftrag ein Startdatum, einen Namen,
                        einen Intervall, eine Kategorie, die Art der Transaktion und den Wert. Diesen Bestätigen Sie mit dem
                        Haken.
                    </div>
                    </p>
                    <hr>
                    <pr>
                        <div class="text-center">
                            <img src="../pictures/Fixaliste.png" class="img-fluid" alt="Haha">
                        </div>
                        <div class="text-center">
                            Nun Sehen Sie eine Liste Ihrer Daueraufträge, diese können Sie mit dem Mülleimer löschen.
                        </div>
                    </pr>
                </div>
            </div>
        </div>
    </div>
    <?php printFooter(); ?>
</body>
</html>
