<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 15.01.2019
 * Time: 13:17
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

    <!-- LESS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
    <!-- Glyphicons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css">

    <title>FAQ</title>
    <script type="text/javascript" src="../js/form.js"></script>
</head>

<body class="background">
<?php printheader(); ?>
<!-- Impressum
================================================== -->
<div class="container border" style="margin-top: 4%;">
    <p>
    <h1>Kontaktinformationen</h1>
    <address>
        <strong>IT-Center Dortmund</strong><br>
        Otto-Hahn-Straße 19<br>
        44227 Dortmund<br>
        <abbr title="Telefonnummer">T:</abbr> +49 231 97513980<br>
        <abbr title="Telefax">F:</abbr> +49 231 97513939<br>
        <abbr title="Email-Adresse">E:</abbr> <a href="mailto:presse@ism.de">presse@ism.de</a>
    </address>
    </p>
    <!-- Haftungsausschluss
    ================================================== -->
    <h1 id="disclaimer">Haftungsausschluss (Disclaimer)</h1>
    <p>Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</p>
    <p class="text-muted">Quelle: <a href="http://www.e-recht24.de/impressum-generator.html">www.e-recht24.de</a></p>
</div>
<?php printFooter(); ?>
</body>
</html>
