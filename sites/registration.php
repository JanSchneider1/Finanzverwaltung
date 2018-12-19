<?php
//Durch require wird die gesamte php-Datei nicht mehr geladen (Essentielle Bestandteile wie Funktionen sollten daher mit require eingebunden werden)
//require_once verhindert mehrfach Inkludierung wodurch ein Fatal-Error enstehen würde . PHP merkt sich, dass die Datei bereits eingebunden wurde.
//include kriegt man nur ein Error und die PHP-Datei wird weiter geladen.

/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 16.11.2018
 * Time: 14:44
 */

require_once __dir__."/../ressources/Repository.php";
require_once __dir__."/../ressources/templates.php";
$repository = new Repository();
$repository->init();
if (isset($_POST["register"]))
    if ($repository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'])){
        //Weiterleitung zum Login
        echo "Hah";
    }
    else {
        echo "profil wurde nicht erstellt";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="/../js/form.js"></script>
    <script>
        function hasUpperCase(string) {
            return (/[A-Z]/.test(string));
        }

        function hasNumber(myString) {
            return /\d/.test(myString);
        }

        function enoughChars(myString) {
            return myString.length>=8;
        }

        function validPassword(password) {
            return (hasUpperCase(password) && hasNumber(password) && enoughChars(password));
        }
    </script>
    <script>
        /*
        var check = function() {
            var password = document.getElementById("password").value;
            var confirmedPassword = document.getElementById("confirmPassword").value;
            if (password != "" && confirmedPassword != "") {
                if (password != confirmedPassword && !validPassword(password) && !validPassword(confirmedPassword)) {
                    document.getElementById("checker").className = "alert alert-danger";
                    document.getElementById("checker").innerHTML = "Bitte geben Sie identische Passwörter ein. Bitte mindestens 8 Zeichen lang, ein Großbuchstabe und eine Zahl.";
                }
                else{
                    document.getElementById("checker").className = "alert alert-success";
                    document.getElementById("checker").innerHTML = "Die Passwörter sind identisch und entsprechen den Vorgaben.";
                }
            }
        }
        */
        var check = function() {
            if (document.getElementById('password').value ==
                document.getElementById('confirmPassword').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'matching';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'not matching';
            }
        }
    </script>
</head>

<body style="background-color: #000000;">

<form class="needs-validation" method="post" novalidate>
    <div class="container" style="max-width: 30%;">
        <div class="border" style="background-color: #333333; padding: 5%; border-radius: 5px;">
            <div class="form-group">
                <h1 class="text-center" style="color: #CCCCCC;">Registrierung</h1>
                <div class="row">
                    <div class="col">
                        <label for="firstname" style="color: #FEFEFE;">Vorname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vorname" required>
                        <div class="invalid-feedback">
                            Bitte einen Vornamen angeben.
                        </div>
                    </div>
                    <div class="col">
                        <label for="lastname" style="color: #FEFEFE;">Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Name" required>
                        <div class="invalid-feedback">
                            Bitte einen Namen angeben.
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email" style="color: #FEFEFE;">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Adresse" required>
                <div class="invalid-feedback">
                    Bitte eine E-Mail angeben.
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                        <span class="col">
                            <label for="password" style="color: #FEFEFE;">Passwort</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Passwort" onkeydown="check();" required>
                            <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Passwort wiederholen"  required>
                            <div class="invalid-feedback">Bitte ein Passwort.</div>
                            <br>
                            <div id="message"></div>
                            <span style="color: #FEFEFE;">Bereits registriert? <a href="login.php">Einloggen</a></span>
                    <button type="submit" class="btn btn-success float-right" name="register">Registrieren</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
</body>
<?php echo printFooter();?>
</html>