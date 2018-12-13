<?php
session_start();
include __dir__."/../ressources/templates.php";
include __dir__."/../ressources/Repository.php";
$repository = new Repository();
$repository->init();
if(isset($_POST["changeEmail"])){
    if ($repository->checkPassword($_SESSION["email"], $_POST["password"])){
        echo "<script type='text/javascript'>alert('Richtige Daten');</script>";

        if ($repository->getUserWithMail($_POST["newEmail"])) {
            echo "<script type='text/javascript'>alert('Email wird bereits genutzt');</script>";
        }
        else {
            if ($_POST["newEmail"]==$_POST["newEmail2"]){
                echo "<script type='text/javascript'>alert('Erfolgreich');</script>";
                $repository->alterUserMail($_SESSION["userId"], $_POST["newEmail"]);
                session_destroy();
                echo "<script type='text/javascript'>location.href = 'Login.php'</script>";
                //ausgeloggt
            }
            else{
                echo "<script type='text/javascript'>alert('Emails nicht identisch');</script>";
            }
        }
    }
    else {
        echo "<script type='text/javascript'>alert('Falsche Daten');</script>";

    }
}


/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 12.12.2018
 * Time: 12:43
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Email ändern</title>
    <script src="/../js/form.js"></script>
</head>

<body style="background-color: #000000;">
<?php printheader();?>

<div class="card mx-auto" style="width: 50%; background-color: #333333;">
    <div class="card-body">
        <nav class="nav nav-pills nav-justified">
            <a class="nav-item nav-link active" href="ChangeEmail.php" style="color: black;">Email ändern</a>
            <a class="nav-item nav-link" href="ChangePassword.php" style="color: black;">Passwort ändern</a>
            <a class="nav-item nav-link" href="DeleteUser.php" style=" color: black;">Profil löschen</a>
        </nav>
        <form method="post" class="needs-validation" novalidate>
            <div class="form-group mx-auto" style="width: 50%;">
                <div class="row">
                    <div class="col">
                        <br>
                        <label for="email" style="color: #FEFEFE;">Neue E-Mail</label>
                        <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="E-Mail" required>
                        <div class="invalid-feedback">
                            Bitte Ihre neue Email eingeben.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="email" style="color: #FEFEFE;">Neue E-Mail bestätigen</label>
                        <input type="email" class="form-control" id="newEmail" name="newEmail2" placeholder="E-Mail" required>
                        <div class="invalid-feedback">
                            Bitte Wiederholen Sie die Email.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="email" style="color: #FEFEFE;">Passwort</label>
                        <input type="email" class="form-control" id="password" name="password" placeholder="Passwort" required>
                        <div class="invalid-feedback">
                            Bitte Ihr Passwort eingeben.
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right" name="changeEmail">Bestätigen</button>
    </div>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
</div>
</form>

</body>
<?php printFooter();?>
</html>
