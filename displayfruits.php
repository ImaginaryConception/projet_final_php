<?php
session_start();

require 'include/db-connection.php';

$allFruits = $db->query("SELECT users.pseudonym FROM users INNER JOIN fruits ON users.id = fruits.user_id WHERE users.id = fruits.user_id");

// Pas fini TODO:

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

    

    <?php require_once 'include/inclusion-js.php'; ?>

</body>
</html>