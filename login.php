<?php
session_start();

require 'include/db-connection.php';

if(isset($_POST['email']) && isset($_POST['password'])){

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

        $errors[] = '<p class="alert alert-danger">Votre adresse e-mail est invalide !</p>';

    }

    if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/u', $_POST['password'])){

        $errors[] = '<p class="alert alert-danger">Le mot de passe doit comprendre au moins 8 caractères dont 1 lettre minuscule, 1 majuscule, un chiffre et un caractère spécial.</p>';

    }

    if(!isset($errors)){

        $userInfo = $db->prepare("SELECT * FROM users WHERE email=?");

        $userInfo->execute([$_POST['email']]);

        $user = $userInfo->fetch();

        if($user){

            if(password_verify($_POST['password'], $user['password'])){

                $success = '<p class="alert alert-success">Vous êtes bien connecté !</p>';

                $_SESSION['user'] = [
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                ];

            } else{

                $errors[] = '<p class="alert alert-danger">Le mot de passe est incorrect !</p>';

            }

        } else{

            $errors[] = '<p class="alert alert-danger">Ce compte n\'existe pas !</p>';

        }

        $userInfo->closeCursor();

        }

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Wikifruit</title>
    <?php require_once 'include/inclusion-css.php'; ?>
</head>
<body>
    <?php require_once 'include/navbar.php'; ?>

    <div class="container col-4">

        <div class="row">

            <div class="mt-5 mb-4">

                <h1 class="register-title">Connexion</h1>

            </div>

            <?php

                if(isset($errors)){

                        foreach($errors as $error){

                        echo $error;

                    }

                }

                if(isset($success)){

                    echo $success;

                } else{

                    ?>

                    <form action="login.php" method="POST">

                    <div class="mt-3">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</span></label>
                            <input type="text" name="email" class="form-control" id="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="text" name="password" class="form-control" id="password">
                        </div>

                        <div>

                            <input value="Connexion" type="submit" class="btn btn-primary col-12">

                        </div>

                    </div>

                    </form>

                    <?php

                }

                ?>

        </div>

    </div>

    <?php require_once 'include/inclusion-js.php'; ?>

</body>
</html>