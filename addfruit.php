<?php
session_start();

require 'include/db-connection.php';



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

    <?php require_once 'include/inclusion-js.php'; ?>

</body>
</html>