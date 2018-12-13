<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 12.12.2018
 * Time: 14:47
 */

session_start();
include __dir__."/../ressources/templates.php";
require_once __dir__."/../ressources/Repository.php";

$repository = new Repository();
$repository->init();

if(isset($_POST["deleteUser"])){
    if ($repository->checkPassword($_POST["email"], $_POST["password"])){
            $repository->deleteUser($_SESSION["userId"]);
            session_destroy();
            //Weiterleitung auf entsprechende Seite sowie Mitteilung
        }
        else{
            //Falsche Daten
        }
}
?>
<script>

</script>

<!DOCTYPE html>
<html>
<head>
    <script src="/../js/form.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Email ändern</title>
</head>

<body style="background-color: #000000;">
<?php printheader();?>

<div class="card mx-auto" style="width: 50%; background-color: #333333;">
    <div class="card-body">
        <nav class="nav nav-pills nav-justified">
            <a class="nav-item nav-link" href="ChangeEmail.php" style="color: black;">Email ändern</a>
            <a class="nav-item nav-link" href="ChangePassword.php" style="color: black;">Passwort ändern</a>
            <a class="nav-item nav-link active" href="DeleteUser.php" style=" color: black;">Profil löschen</a>
        </nav>
        <form method="post" class="needs-validation" novalidate>
            <div class="form-group mx-auto" style="width: 50%;">
                <div class="row">
                    <div class="col">
                        <br>
                        <label for="email" style="color: #FEFEFE;">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="" required>

                        <div class="invalid-feedback">
                            Bitte Ihre Email eingeben.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="email" style="color: #FEFEFE;">Passwort</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                        <div class="invalid-feedback">
                            Bitte ihr Passwort eingeben.
                        </div>

                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right" name="deleteUser">Bestätigen</button>
    </div>
</div>
</form>

</body>
<?php printFooter();?>
</html>
