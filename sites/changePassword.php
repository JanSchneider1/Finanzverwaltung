<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 12.12.2018
 * Time: 14:42
 */
session_start();
include __dir__."/../ressources/templates.php";
include __dir__."/../ressources/Repository.php";
$repository = new Repository();
$repository->init();
setRedirect();
if (isset($_POST["changePassword"])) {
    if ($repository->checkPassword($_SESSION["email"], $_POST["currentPassword"])){
        if ($_POST["newPassword"]==$_POST["newPassword2"]){
            echo "<script type='text/javascript'>alert('Erfolgreich');</script>";
            $repository->alterUserPassword($_SESSION["userId"], $_POST["newPassword"]);
            header('Location: ../ressources/logout.php');
        }
        else{
            //Emails nicht identisch evtl noch mit JS
            $error = "<br><div class='alert alert-danger' role='alert'>Die Emails sind nicht idetisch.</div>";
        }
    }
    else {
        $error = "<br><div class='alert alert-danger' role='alert'>Die Kombination aus Mail und Passwort ist nicht korrekt.</div>";
    }

}


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

    <title>Passwort ändern</title>
    <script type="text/javascript" src="../js/form.js"></script>
</head>

<body class="background">
<?php printheader();?>

<div class="card mx-auto" style="width: 50%; background-color: #333333;">
    <div class="card-body">
        <nav class="nav nav-pills nav-justified">
            <a class="nav-item nav-link" href="changeEmail.php" style="color: white;">Email ändern</a>
            <a class="nav-item nav-link" href="changePassword.php" style="background-color: #DDDDDD; color: black;">Passwort ändern</a>
            <a class="nav-item nav-link" href="deleteUser.php" style="color: white;">Profil löschen</a>
        </nav>
        <form method="post" class="needs-validation" novalidate>
            <div class="form-group mx-auto" style="width: 50%;">
                <div class="row">
                    <div class="col">
                        <br>
                        <label for="currentpassword" style="color: #FEFEFE;">Altes Passwort</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="" required>

                        <div class="invalid-feedback">
                            Bitte Ihr Passwort eingeben.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="newpassword" style="color: #FEFEFE;">Neues Passwort</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="" required>

                        <div class="invalid-feedback">
                            Bitte Ihr neues Passwort eingeben.
                        </div>
                    </div>
                </div>
                <label for="newpassword2" style="color: #FEFEFE;">Neues Passwort bestätigen</label>
                <input type="password" class="form-control" id="newPassword2" name="newPassword2" placeholder="" required>
                <?php
                if ((isset($error))) {
                    echo $error;
                }
                ?>
            </div>
            <button type="submit" class="btn btn-success float-right" name="changePassword">Bestätigen</button>
    </div>
</div>
</form>

</body>
<?php printFooter();?>
</html>
