<?php
    $this->cache = \Config\Services::cache();
	$connectedUsername = $this->cache->get('email');
?>
<html>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a href="home">
                <img class="logo" src="logo.png ">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=!empty($connectedUsername) ? 'myaccount' : 'login' ?>">
                            <i class="fas fa-user"></i> 
                            <?= !empty($connectedUsername ) ? $connectedUsername : 'Se connecter/ S\'inscrire' ?> 
                        </a>
                    </li>
                    <?php if(!empty($connectedUsername) ) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout"><i class="fas fa-sign-out-alt"></i> Se déconnecter </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="catalogue"><i class="fas fa-search"></i> Catalogue</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="panier"><i class="fas fa-shopping-basket"></i> Panier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="commande"><i class="fas fa-clipboard-list"></i> Commande</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

</html>


<style>
    .logo {
        width: 80px;
        margin-right: 100px;
    }

    nav li {
        display: inline;
        padding-right: 100px;
    }
</style>