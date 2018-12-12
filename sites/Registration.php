<?php
//Durch require wird die gesamte php-Datei nicht mehr geladen (Essentielle Bestandteile wie Funktionen sollten daher mit require eingebunden werden)
//require_once verhindert mehrfach Inkludierung wodurch ein Fatal-Error enstehen würde . PHP merkt sich, dass die Datei bereits eingebunden wurde.
//include kriegt man nur ein Error und die PHP-Datei wird weiter geladen.
require_once __dir__."/Repository.php";
$repository = new Repository();
$repository->init();
if (isset($_POST["register"]))
    if ($repository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'])){
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
        <script>
            (function() {
                "use strict";
                window.addEventListener("load", function() {
                    var forms = document.getElementsByClassName("needs-validation");
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener("submit", function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add("was-validated");
                        }, false);
                    });
                }, false);
            })();
        </script>

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
            var check = function() {
                var password = document.getElementById("password").value;
                var confirmedPassword = document.getElementById("confirmPassword").value;
                alert(password!="");
                alert(confirmedPassword!="");
                alert(password != "" && confirmedPassword != "");
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
                alert(password); alert(confirmedPassword);
                alert('Passwort ungleich Bestätigungspasswort ergibt: ' + password==confirmedPassword);
                alert("Passwortcheck von beiden Passwörter ergibt: " + !validPassword(password) && !validPassword(confirmedPassword));
            }
        </script>
    </head>

    <body>

    <form class="needs-validation" method="post" novalidate>
        <div class="container" style="max-width: 30%;">
            <div class="border" style="background-color: lightgrey; padding: 5%; border-radius: 5px;">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="firstname">Vorname</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vorname" required>
                            <div class="invalid-feedback">
                                Bitte einen Vornamen angeben.
                            </div>
                        </div>
                        <div class="col">
                            <label for="lastname">Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Name" required>
                            <div class="invalid-feedback">
                                Bitte einen Namen angeben.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Adresse" required>
                    <div class="invalid-feedback">
                        Bitte eine E-Mail angeben.
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <span class="col">
                            <label for="password">Passwort</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Passwort" onclick="check();" required>
                            <label for="confirmPassword">Passwort bestätigen</label>
                            <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Selbes Passwort"  required>
                            <div class="invalid-feedback">Bitte ein Passwort.</div>
                            <br>
                            <div id="checker"></div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Registrieren</button>
        </div>
        </div>
    </form>
    </body>

    </html>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 16.11.2018
 * Time: 14:44
 */
?>