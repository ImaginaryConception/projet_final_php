<?php

try {

    $db = new PDO('mysql:host=localhost;dbname=php_final_project;charset=utf8', 'root', '');

} catch (Exception $e) {

    die('Problème dans la base de données : ' . $e->getMessage());

}

?>