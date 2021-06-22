<?php include "menu.php"; ?>
<div class="container pt-5">
    <div class="row align-items-center justify-content-between">
        <div class="wrap col-md-3 col-5 text-right order-md-1">
            <div class="search">
                <input type="text" id="searchContent" class="searchTerm" placeholder="What are you looking for?">
                <button type="submit" class="searchButton">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <div class="col-md-3 order-md-0 mt-2 mt-md-0">
            <select class="form-control form-control-sm">
                <option value="">Sort By</option>
                <option value="">Price</option>
            </select>  
        </div>


        <div class="slidecontainer">
            <label for="price-min" id="price-min-label">Price min : </label>
            <input type="number" data-type="range" name="price-min" id="valueMinPriceFilter" value="1" min="1" max="5000">
            <label for="price-max" id="price-max-label">Price max : </label>
            <input type="number" data-type="range" name="price-max" id="valueMaxPriceFilter" value="5000" min="1" max="5000">
            <button id = "btnPriceFilter" class="btn btn-outline-primary btn-block">Apply</button>
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
            <div class="d-flex justify-content-between position-absolute w-100">
                <div class="label-sale">
                    <span class="text-white bg-primary small d-flex align-items-center px-2 py-1">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                        <span class="ml-1">Sale</span>
                    </span>
                </div>
            </div>
            <a href="#">
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
        <p class="mb-0"> 
            <strong>
            <a href="#" id="product-title" class="text-secondary">{{nomProduit}} {{numProduit}}</a>
            </strong>
        </p>

        <div class="d-flex justify-content-between mt-auto">
            <form action="add-panier" method="post">
                <div class="input-group col-8 mr-2">
                    <input class="form-control" onkeyup="checkQuantite(this)" type="number" name="quantite" min="1" max="5" value="1" />
                </div> <br>
                <div class="col px-0">
                <input hidden name="num" value="{{numProduit}}"/>
                <input hidden name="nom" value="{{nomProduit}}"/>
                <input hidden name="prix" value="{{prixProduit}}"/>

                <button class="btn btn-outline-primary btn-block">
                    Add To Cart
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                </button>
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

<!-- Les requetes sont present dans le fichier /public/catalogue.js  -->
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
border: 3px solid #00B4CC;
border-right: none;
padding: 5px;
border-radius: 5px 0 0 5px;
outline: none;
color: #9DBFAF;
}

.searchTerm:focus{
color: #00B4CC;
}

.searchButton {
width: 40px;
border: 1px solid #00B4CC;
background: #00B4CC;
text-align: center;
color: #fff;
border-radius: 0 5px 5px 0;
cursor: pointer;
font-size: 20px;
}

    .searchButton {
        width: 40px;
        border: 1px solid #00B4CC;
        background: #00B4CC;
        text-align: center;
        color: #fff;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 20px;
    }
</style>