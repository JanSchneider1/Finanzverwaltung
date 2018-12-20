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
        echo "<script type='text/javascript'>alert('Richtige Daten');</script>";
        if ($_POST["newPassword"]==$_POST["newPassword2"]){
            echo "<script type='text/javascript'>alert('Erfolgreich');</script>";
            $repository->alterUserPassword($_SESSION["userId"], $_POST["newPassword"]);
            session_destroy();
            echo "<script type='text/javascript'>location.href = 'login.php'</script>";
            //ausgeloggt
        }
        else{
            echo "<script type='text/javascript'>alert('Emails nicht identisch');</script>";
        }
    }
}
else {
//Falsche daten
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Passwort ändern</title>
    <link rel="stylesheet" href="../css/general.less">
    <link rel="stylesheet" href="../css/assets/hover-min.css">
    <link rel="stylesheet/less" type="text/css" href="../css/general.less">
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
    <script type="text/javascript" src="../js/form.js"></script>
</head>

<body style="background-color: #000000;">
<?php printheader();?>

<div class="card mx-auto" style="width: 50%; background-color: #333333;">
    <div class="card-body">
        <nav class="nav nav-pills nav-justified">
            <a class="nav-item nav-link" href="changeEmail.php" style="color: black;">Email ändern</a>
            <a class="nav-item nav-link active" href="changePassword.php" style="color: black;">Passwort ändern</a>
            <a class="nav-item nav-link" href="deleteUser.php" style=" color: black;">Profil löschen</a>
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
            </div>
            <button type="submit" class="btn btn-success float-right" name="changePassword">Bestätigen</button>
    </div>
</div>
</form>

</body>
<?php printFooter();?>
</html>
