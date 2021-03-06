<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 16.11.2018
 * Time: 14:42
 */
session_start();
include __dir__."/../ressources/templates.php";
require_once __dir__.'/../ressources/Repository.php';
$repository = new Repository();
$repository->init();
if(isset($_POST["login"])){
    if ($repository->checkPassword($_POST["email"], $_POST["password"])){

        $_SESSION["userId"] = $repository->getUserWithMail($_POST["email"])["UserID"];
        $_SESSION["email"] = $repository->getUserWithMail($_POST["email"])["Mail"];
        header('Location: ../sites/home.php');
    }
    else{
        $error = "<br><div class='alert alert-danger' role='alert'>Die Kombination aus Mail und Passwort ist nicht korrekt.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body style="background-color: #000000;">

</br></br></br></br></br></br>

<form method="post" class="needs-validation" novalidate>
    <div class="container" style="max-width: 30%;">
        <div class="border" style="background-color: #333333; padding: 5%; border-radius: 5px;">
            <div class="form-group">
                <h1 style="color: #CCCCCC;" class="text-center">Login</h1>
                <div class="row">
                    <div class="col">
                        <label for="email" style="color: #FEFEFE;">E-Mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" required>
                        <div class="invalid-feedback">
                            Bitte eine E-Mail eingeben.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="password" style="color: #FEFEFE;">Passwort</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" required>
                        <div class="invalid-feedback">
                            Bitte ein Passwort eingeben.
                        </div>
                    </div>
                </div>
                <?php
                if ((isset($error))) {
                    echo $error;
                }
                ?>
                <br>
                <div class="row">
                    <div class="col">
                        <span style="color: #FEFEFE;">Noch nicht registriert? Registriere dich <a href="registration.php">hier</a></span>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-success float-right" name="login">Einloggen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>

</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>

<?php printFooter(); ?>

</html>