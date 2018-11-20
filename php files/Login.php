<?php
include('Repository.php');
$repository = new Repository();
$repository->init();

if(isset($_POST["login"])){
    echo $repository->checkPassword($_POST["email"], $_POST["password"]);
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

<form method="post">
    <div class="container" style="max-width: 30%;">
        <div class="border" style="background-color: lightgrey; padding: 5%; border-radius: 5px;">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Einloggen</button>
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
 * Time: 14:42
 */