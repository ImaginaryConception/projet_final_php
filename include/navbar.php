<?php
include 'inclusion-css.php';

if(isset($_SESSION['user'])){

    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">Wikifruit</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Liste des Fruits</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="logout.php">Déconnexion</a>
            </li>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="profil.php">Mon Profil</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="addfruit.php">Ajouter un Fruit</a>
            </li>
        </ul>
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Chercher un fruit" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        </div>
    </div>
    </nav>

    <?php

} else{

    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">Wikifruit</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">Accueil</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Liste des Fruits</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="register.php">Inscription</a>
            </li>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="login.php">Connexion</a>
            </li>
        </ul>
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Chercher un fruit" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        </div>
    </div>
    </nav>

    <?php

}