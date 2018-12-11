<?php
session_start();
require_once __dir__.'/../ressources/Repository.php';
$repository = new Repository();
$repository->init();

if(isset($_POST["login"])){
    if ($repository->checkPassword($_POST["email"], $_POST["password"])){

        $_SESSION["userId"];

        $abfrage = "select UserID from User where mail=".$_POST["email"]." and password=".$_POST["password"];
    }
}

?>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

<form method="post" class="needs-validation" novalidate>
    <div class="container" style="max-width: 30%;">
        <div class="border" style="background-color: lightgrey; padding: 5%; border-radius: 5px;">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Adresse" required>
                <div class="invalid-feedback">
                    Bitte eine E-Mail eingeben.
                </div>
                <label for="password">Passwort</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" required>
                <div class="invalid-feedback">
                    Bitte ein Passwort eingeben.
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Einloggen</button>
        </div>
    </div>
</form>
</body>

</html>