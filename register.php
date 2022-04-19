<?php
session_start();

require 'recaptchaValid.php';

require 'include/db-connection.php';

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['nickname']) && isset($_POST['g-recaptcha-response'])){

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

        $errors[] = '<p class="alert alert-danger">Votre adresse e-mail est invalide !</p>';

    }

    if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/u', $_POST['password'])){

        $errors[] = '<p class="alert alert-danger">Le mot de passe doit comprendre au moins 8 caractères dont 1 lettre minuscule, 1 majuscule, un chiffre et un caractère spécial.</p>';

    }

    if($_POST['confirm_password'] != $_POST['password']){

        $errors[] = '<p class="alert alert-danger">La confirmation ne correspond pas au mot de passe</p>';

    }

    if(mb_strlen($_POST['nickname']) < 1 || mb_strlen($_POST['nickname']) > 50){

        $errors[] = '<p class="alert alert-danger">Le pseudonyme doit contenir entre 1 et 50 caractères</p>';

    }

    if(!recaptchaValid($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'])){

        $errors[] = '<p class="alert alert-danger">Veuillez remplir correctement le captcha</p>';

    }

    $userInfo = $db->prepare("SELECT * FROM users WHERE email=?");

    $userInfo->execute([$_POST['email']]);

    $user = $userInfo->fetch();

    if($user){

        $errors[] = '<p class="alert alert-danger">Cette adresse e-mail a déjà été utilisé !</p>';

    }

    if(!isset($errors)){

        $userInfo = $db->prepare("INSERT INTO users (email, password, pseudonym, register_date) VALUES (?, ?, ?, ?)");

        $querySuccess = $userInfo->execute([

            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_BCRYPT),
            $_POST['nickname'],
            Date('Y-m-d H:i:s'),

    ]);

    if($querySuccess){

        $success = '<p class="alert alert-success">Votre compte a bien été créé !</p>';

    } else{

        $errors [] = '<p class="alert alert-danger">Inscription échoué... Veuillez réessayez !';

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
    <title>Inscription - Wikifruit</title>
    <?php require_once 'include/inclusion-css.php'; ?>
</head>
<body>
    <?php require_once 'include/navbar.php'; ?>

    <div class="container col-4">

        <div class="row">

            <div class="mt-5 mb-4">

                <h1 class="register-title">Créer un compte sur Wikifruit</h1>

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

                    <form action="register.php" method="POST">

                    <div class="mt-3">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="link-danger">*</span></label>
                            <input type="text" name="email" class="form-control" id="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe <span class="link-danger">*</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmation mot de passe <span class="link-danger">*</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                        </div>

                        <div class="mb-3">
                            <label for="nickname" class="form-label">Pseudonyme <span class="link-danger">*</label>
                            <input type="text" name="nickname" class="form-control" id="nickname">
                        </div>

                        <div class="mb-3">

                        <label for="captcha" class="mb-2">Captcha <span class="link-danger">*</label>
                        <div class="g-recaptcha" id="captcha" data-sitekey="6Ld9YncfAAAAAHNrGOh812dxkaeh3zPT9Na0xHF8"></div>

                        </div>

                        <div>

                            <input value="Créer mon compte" type="submit" class="btn btn-success col-12">

                        </div>

                        <div class="mt-3">

                            <p class="link-danger">* Champs obligatoires</p>

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