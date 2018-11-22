<?php
//Durch Require wird die gesamte php-Datei nicht mehr gelanden (Essentielle Bestandteile wie Funktionen sollten daher mit require geholt werden)
//Require verhindert mehrfach inkludierung wodurch ein Fatal-Error ensteht. PHP merkt sich, dass die Datei bereits eingebunden wurde
/// //Durch include kriegt man nur ein Error und die PHP-Datei wird weiter geladen.
require_once __dir__."/Repository.php";
$repository = new Repository();
$repository->init();
if (isset($_POST["register"])){
    echo $repository->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
}
?>


    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <meta charset="UTF-8">
        <title>Register</title>
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

        <script>
            var check = function() {
                if (document.getElementById("password").value != document.getElementById("confirmPassword").value) {
                    document.getElementById("checker").innerHTML = 'Bitte identische Passwörter';
                }
                else {
                    document.getElementById("checker").innerHTML = "Passwörter sind identisch";
                }
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
                            <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" onkeyup='check();' required>

                            <label for="confirmPassword">Passwort bestätigen</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Selbes Passwort" onkeyup='check();' required>
                            <div class="invalid-feedback">Bitte ein Passwort.</div>

                             <div class="alert alert-danger" id="checker"></div>

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