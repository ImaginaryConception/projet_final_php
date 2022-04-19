<?php
session_start();

require 'include/db-connection.php';

if(!isset($_SESSION['user'])){

    $error = '<div class="container col-4 mt-5 mb-4"><p class="alert alert-warning">Vous devez être connecté <a href="login.php">(en cliquant ici)</a> pour venir sur cette page !</p></div>';

}

if(isset($_SESSION['user']['email'])){

    $userInfos = $db->prepare("SELECT * FROM users WHERE email=?");

    $userInfos->execute([$_SESSION['user']['email']]);

};

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Wikifruit</title>
    <?php require_once 'include/inclusion-css.php'; ?>
</head>
<body>
    <?php require_once 'include/navbar.php';?>

    <div class="container">

    <?php

    if(isset($error)){

        echo $error;

        } else{

            ?>

            <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 py-5">
                    <h1 class="pb-4 text-center">Mon Profil</h1>
                    <div class="row">
                        <div class="col-md-6 col-12 offset-md-3 my-4">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Email</strong> : <?php foreach($userInfos as $userInfo){echo $userInfo;} ?></li>

                                <li class="list-group-item"><strong>Pseudo</strong> : <?php  ?></li>
                                <li class="list-group-item"><strong>Date d'inscription</strong> : <?php  ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

        }

        ?>

        </div>


    <?php require_once 'include/inclusion-js.php'; ?>

</body>
</html>