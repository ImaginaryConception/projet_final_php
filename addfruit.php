<?php
session_start();

require 'include/db-connection.php';

$allowedTypes = ['image/jpeg', 'image/png'];

if(isset($_POST['name']) && isset($_POST['origin']) && isset($_FILES['picture']) && isset($_POST['description'])){

    if(mb_strlen($_POST['name']) < 1 || mb_strlen($_POST['name']) > 50){

        $errors[] = '<p class="alert alert-danger">Le nom doit contenir entre 1 et 50 caractères !</p>';

    }

    if(mb_strlen($_POST['description']) > 0){

        if(mb_strlen($_POST['description']) < 5 || mb_strlen($_POST['description']) > 20000){

            $errors[] = '<p class="alert alert-danger">La description doit contenir entre 5 et 20 000 caractères !</p>';

        }

    } else{

        $fruitInfo = $db->prepare("INSERT INTO fruits (name, origin, user_id) VALUES (?, ?, '1')");

        $fruitInfo->execute([

            $_POST['name'],
            $_POST['origin'],

        ]);

    }

    if(!isset($_POST['origin']) || $_POST['origin'] != 'fr' && $_POST['origin'] != 'es' && $_POST['origin'] != 'jp' && $_POST['origin'] != 'de'){
        $errors[] = '<p class="alert alert-danger">Veuillez choisir un pays !</p>';
    }

    $file = $_FILES['picture'];

    if($file['error'] == 0){

        $realTypes = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file['tmp_name']);

        if(!in_array($realTypes, $allowedTypes)){

            $errors[] = '<p class="alert alert-danger">Le fichier doit être au format png ou jpg !</p>';

        }

    } else if($file['error'] == 1 && $file['error'] = 2 && $file['size'] > 5242880){

        $errors[] = '<p class="alert alert-danger">La taille du fichier ne doit pas dépasser 5 Mo !</p>';

    } else if($file['error'] == 3){

        $errors[] = '<p class="alert alert-danger">le fichier n\'a pas été reçu en entier, vérifiez votre connexion puis réessayez !</p>';

    } else if($file['error'] == 4 && mb_strlen($_POST['description']) > 0){

        $fruitInfo = $db->prepare("INSERT INTO fruits (name, origin, description, user_id) VALUES (?, ?, ?, '1')");

        $fruitInfo->execute([

            $_POST['name'],
            $_POST['origin'],
            $_POST['description'],

        ]);

    } else if($file['error'] == 6 && $file['error'] = 7 && $file['error'] = 8){

        $errors[] = '<p class="alert alert-danger">Une erreur est survenue côté serveur. Réessayez !</p>';

    }

    if(!isset($errors)){

        if($file['error'] == 0){

            $newFileName = md5(random_bytes(50) . time());

            $errorMessage = '<p class="error">Le nom de ce fichier est déjà utilisé. Choissisez-en un autre !</p>';

            if(file_exists('images/uploads/' . $newFileName . '.png')){

                $errors[] = $errorMessage;

                rename('images/uploads/' . $newFileName . '.png', 'images/uploads/' . $newFileName . '.png');

            } else if(file_exists('images/uploads/' . $newFileName . '.jpg')){

                $errors[] = $errorMessage;

                rename('images/uploads/' . $newFileName . '.jpg', 'images/uploads/' . $newFileName . '.jpg');

            }

            if($realTypes == 'image/png'){

                move_uploaded_file($file['tmp_name'], 'images/uploads/' . $newFileName . '.png');

            } else if($realTypes == 'image/jpeg'){

                move_uploaded_file($file['tmp_name'], 'images/uploads/' . $newFileName . '.jpg');

            }

            $fruitInfo = $db->prepare("INSERT INTO fruits (name, origin, description, picture_name, user_id) VALUES (?, ?, ?, ?, '1')");

            $fruitInfo->execute([

                $_POST['name'],
                $_POST['origin'],
                $_POST['description'],
                $newFileName,

            ]);

        }

        $fruitInfo->closeCursor();

        $success =  '<p class="alert alert-success">Le fruit a bien été créé !</p>';

    }

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un fruit - Wikifruit</title>
    <?php require_once 'include/inclusion-css.php'; ?>
</head>
<body>
    <?php require_once 'include/navbar.php';?>

    <div class="container-fluid">

        <div class="row">

            <div class="col-12 col-md-8 offset-md-2 py-5">

                <h1 class="pb-4 text-center">Ajouter un fruit</h1>

                <div class="col-12 col-md-6 offset-md-3">

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

                            <form action="addfruit.php" method="POST" enctype="multipart/form-data">

                            <div class="mb-3">

                                <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input placeholder="Banane" id="name" type="text" name="name" class="form-control">

                            </div>

                            <div class="mb-3">

                                <label for="origin" class="form-label">Pays d'origine <span class="text-danger">*</span></label>
                                <select id="origin" name="origin" class="form-select">

                                    <option selected disabled>Sélectionner un pays</option>
                                    <option value="fr">France</option><option value="de">Allemagne</option><option value="es">Espagne</option><option value="jp">Japon</option>

                                </select>

                            </div>

                            <input type="hidden" name="MAX_FILE_SIZE" value="5242880">

                            <div class="mb-3">

                                <label for="picture" class="form-label">Photo</label>
                                <input type="file" class="form-control" id="picture" name="picture" accept="image/png, image/jpeg">

                            </div>

                            <div class="mb-3">

                                <label for="description" class="form-label">Description <span class="text-danger"></span></label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Description..."></textarea>

                            </div>

                            <div>

                                <input value="Créer le fruit" type="submit" class="btn btn-primary col-12">

                            </div>

                            <p class="text-danger mt-4">* Champs obligatoires</p>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <?php

    }

    require_once 'include/inclusion-js.php'; ?>

</body>
</html>