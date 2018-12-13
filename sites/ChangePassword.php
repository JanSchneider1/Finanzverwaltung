<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 12.12.2018
 * Time: 14:42
 */

session_start();
include __dir__."/../ressources/templates.php";
?>
<script src="/../js/form.js"></script>
<!DOCTYPE html>
<html>
<head>
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
            <a class="nav-item nav-link active" href="ChangePassword.php" style="color: black;">Passwort ändern</a>
            <a class="nav-item nav-link" href="DeleteUser.php" style=" color: black;">Profil löschen</a>
        </nav>
        <form method="post" class="needs-validation" novalidate>
            <div class="form-group mx-auto" style="width: 50%;">
                <div class="row">
                    <div class="col">
                        <br>
                        <label for="currentpassword" style="color: #FEFEFE;">Altes Passwort</label>
                        <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="" required>

                        <div class="invalid-feedback">
                            Bitte Ihr Passwort eingeben.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="newpassword" style="color: #FEFEFE;">Neues Passwort</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="" required>

                        <div class="invalid-feedback">
                            Bitte Ihr neues Passwort eingeben.
                        </div>
                    </div>
                </div>
                <label for="newpassword2" style="color: #FEFEFE;">Neues Passwort bestätigen</label>
                <input type="password" class="form-control" id="newpassword2" name="newpassword2" placeholder="" required>
            </div>
            <button type="submit" class="btn btn-success float-right" name="changePassword">Bestätigen</button>
    </div>
</div>
</form>

</body>
<?php printFooter();?>
</html>
