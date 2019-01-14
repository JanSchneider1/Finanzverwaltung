<?php
session_start();
include __dir__."/../ressources/templates.php";
require_once __dir__."/../ressources/Repository.php";
$repository = new Repository();
$repository->init();
setRedirect();
if(isset($_POST["changeEmail"])){
    if ($repository->checkPassword($_SESSION["email"], $_POST["password"])){
        if ($repository->getUserWithMail($_POST["newEmail"])) {
            $error = "<br><div class='alert alert-danger' role='alert'>Diese Email ist bereits vergeben.</div>";
        }
        else {
            if ($_POST["newEmail"]==$_POST["newEmail2"]){
                echo "<script type='text/javascript'>alert('Erfolgreich');</script>";
                $repository->alterUserMail($_SESSION["userId"], $_POST["newEmail"]);
                header('Location: ../ressources/logout.php');
            }
            else{
                $error = "<br><div class='alert alert-danger' role='alert'>Die Kombination aus Mail und Passwort ist nicht korrekt.</div>";
            }
        }
    }
    else {
        $error = "<br><div class='alert alert-danger' role='alert'>Die Kombination aus Mail und Passwort ist nicht korrekt.</div>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <!-- Glyphicons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css">

    <!-- My stylesheets -->
    <link rel="stylesheet" href="../css/assets/texteffects.css">
    <link rel="stylesheet" href="../css/assets/hover-min.css">
    <link rel="stylesheet/less" type="text/css" href="../css/general.less">

    <!-- LESS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>

    <title>Email ändern</title>
    <script type="text/javascript" src="../js/form.js"></script>
</head>

<body class="background">
<?php printheader();?>


</br></br></br></br>
<div class="card mx-auto" style="width: 50%; background-color: #333333;">
    <div class="card-body">
        <nav class="nav nav-pills nav-justified">
            <a class="nav-item nav-link" href="changeEmail.php" style="background-color: #17191c; color: white; border: white 1px solid;">Email ändern</a>
            <a class="nav-item nav-link" href="changePassword.php" style="color:white;">Passwort ändern</a>
            <a class="nav-item nav-link" href="deleteUser.php" style="color:white;">Profil löschen</a>
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
                        <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" required>
                        <div class="invalid-feedback">
                            Bitte Ihr Passwort eingeben.
                        </div>
                    </div>
                </div>
                <?php
                if ((isset($error))) {
                    echo $error;
                }
                ?>
            </div>
            <button type="submit" class="btn btn-success float-right" name="changeEmail">Bestätigen</button>
    </div>
</div>
</form>
</br></br></br></br></br></br></br></br></br></br></br></br></br></br>
</body>
<?php printFooter();?>
</html>
