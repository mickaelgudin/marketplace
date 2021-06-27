<?php include "menu.php"; ?>
<div class="container pt-5">
    <div class="row align-items-center justify-content-between">
        <div class="col-md-3 order-md-0 mt-2">
            <label for="sorted-select"> Trier par : </label>
            <select class="form-control form-control-sm" id="sorted-select" onchange="sendSearchElasticByPriceAndPreviousName()">
                <option value="nom-asc" type="text">Nom A à Z</option>
                <option value="nom-desc" type="text">Nom Z à A</option>
                <option value="prix-asc" type="text">Prix croissant</option>
                <option value="prix-desc" type="text">Prix décroissant</option>
            </select>  
        </div>

        <div class="wrap col-md-5 col-5 text-right">
            <div class="search">
                <input type="text" id="searchContent" class="searchTerm" placeholder="Produit recherché?">
                <button type="submit" class="searchButton" onclick="sendSearchElasticByPriceAndPreviousName()">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <div class="slidecontainer">
            <label for="price-min" id="price-min-label">Prix min : </label>
            <input type="number" data-type="range" name="price-min" id="valueMinPriceFilter" value="1" min="1" max="5000">
            <label for="price-max" id="price-max-label">Prix max : </label>
            <input type="number" data-type="range" name="price-max" id="valueMaxPriceFilter" value="5000" min="1" max="5000">
            <button id = "btnPriceFilter" class="btn btn-primary btn-block" onclick="sendSearchElasticByPriceAndPreviousName()">
                Appliquer les filtres
            </button>
            <button class="btn btn-danger btn-block" id="btn-reset-filters" onclick="resetFilters()">Supprimer les filtres</button>
        </div>


    </div>
</div>

<div class="container">
<hr />
</div>

<div id="container-product" class="container">

</div>

<div class="container">
<hr />
</div>

<!-- Template pour un produit, il est utilise par le fichier /public/catalogue.js pour afficher les produits retournes par elasticsearch -->
<template id="product-item">
<div class="row">
    <div class="col-md-6 mb-3 mx-auto">
        <div class="card h-100">
            
        <a href="{{numProduit}}.png">
        <img src="{{numProduit}}.png" class="card-img-top" alt="Product">
        </a>
        <div class="card-body px-2 pb-2 pt-1">
        <div class="d-flex justify-content-between">
            <div>
            <p class="h4 text-primary">{{prixProduit}} €</p>
            </div>
            <div>
            <a href="#" class="text-secondary lead" data-toggle="tooltip" data-placement="left" title="Compare">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
            </a>
            </div>
        </div>
        <p class="mb-2" > 
            <strong>
            <a href="#" id="product-title" class="text-secondary">Nom : {{nomProduit}} <br> Référence: {{numProduit}}</a>
            </strong>
            
        </p>

        <div class="justify-content-between mt-auto">
            <form action="add-panier" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <input class="form-control" onkeyup="checkQuantite(this)" type="number" name="quantite" min="1" max={{quantiteProduit}} value="1" />
                            
                        </div>
                        <div class="col-sm">
                            <button class="btn btn-primary btn-block">
                                Ajouter au panier
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <input hidden name="quantite_stock" value="{{quantiteProduit}}"/>
                <input hidden name="num" value="{{numProduit}}"/>
                <input hidden name="nom" value="{{nomProduit}}"/>
                <input hidden name="prix" value="{{prixProduit}}"/>
            </form>
            </div>
        </div>
        </div>
        </div>
        </div>
    </div>
    </div>
</div>
</template>

</body>
</html>

<!-- Les requetes et fonction pour elasticsearch sont present dans le fichier /public/catalogue.js  -->
<script src="catalogue.js"></script>

<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans);

body{
    background: #f2f2f2;
    font-family: 'Open Sans', sans-serif;
}

.search {
    width: 100%;
    position: relative;
    display: flex;
}

.searchTerm {
    width: 100%;
    border: 3px solid #007BFF;
    border-right: none;
    padding: 5px;
    border-radius: 5px 0 0 5px;
    outline: none;
    color: gray;
}

.searchTerm:focus{
    color: #00B4CC;
}

.searchButton {
    width: 40px;
    border: 1px solid #007BFF;
    background: #007BFF;
    text-align: center;
    color: #fff;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    font-size: 20px;
}
</style>