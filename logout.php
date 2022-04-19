<?php
session_start();

if(isset($_SESSION['user'])){

    $success = '<p class="alert alert-success">Vous avez bien été déconnecté !</p>';

    unset($_SESSION['user']);

} else{

    $error = '<p class="alert alert-warning">Vous devez être connecté <a href="login.php">(en cliquant ici)</a> pour venir sur cette page !</p>';

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - Wikifruit</title>
    <?php require_once 'include/inclusion-css.php'; ?>
</head>
<body>
    <?php require_once 'include/navbar.php'; ?>

    <div class="container col-4 mt-5 mb-4">

                <?php

                if(isset($success)){

                echo $success;

                }

                if(isset($error)){

                echo $error;

                }

                ?>

            </div>

    <?php require_once 'include/inclusion-js.php'; ?>

</body>
</html>