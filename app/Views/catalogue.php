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

</body>
</html>


<script>
  
let valueMinPriceFilter = document.getElementById("valueMinPriceFilter");
let valueMaxPriceFilter = document.getElementById("valueMaxPriceFilter");

// elastic search query's result when page loaded
let headers = new Headers();
headers.append('Content-Type', 'application/json');
fetch("http://127.0.0.1:9200/produits/_doc/_search",{
        method:"POST",
        headers: headers,
        mode : 'cors',
        body:  JSON.stringify(
        {
            "query": {
                "range": {
                    "quantite_stock": {
                        "gt" : Number(0)
                    }
                }
            }
        }
    )
})
.then(response=>response.json())
.then(data=>getAllProducts(data.hits.hits));

function getAllProducts(resp){
    resp.forEach(function(element){
        let title = document.querySelector('#product-title');
        let containerProduct = document.querySelector('#container-product');
        containerProduct.innerHTML = containerProduct.innerHTML +  '<div class="row"> '
        +'<div class="col-md-4 mb-3"> '
        +'<div class="card h-100"> '
        +'<div class="d-flex justify-content-between position-absolute w-100"> '
        +'<div class="label-sale"> '
            +'<span class="text-white bg-primary small d-flex align-items-center px-2 py-1"> ' 
            +'<i class="fa fa-tag" aria-hidden="true"></i> '
            +'<span class="ml-1">Sale</span> '
            +'</span> '
        +'</div> '
        +'</div> '
        +'<a href="#"> '
        +'<img src="https://picsum.photos/700/550" class="card-img-top" alt="Product"> '
        +'</a> '
        +'<div class="card-body px-2 pb-2 pt-1"> '
        +'<div class="d-flex justify-content-between"> '
            +'<div> '
            +'<p class="h4 text-primary">$'+element._source.prix+'</p> '
            +'</div> '
            +'<div> '
            +'<a href="#" class="text-secondary lead" data-toggle="tooltip" data-placement="left" title="Compare"> '
                +'<i class="fa fa-line-chart" aria-hidden="true"></i> '
            +'</a> '
            +'</div> '
        +'</div> '
        +'<p class="mb-0"> '
            +'<strong> '
            +'<a href="#" id="product-title" class="text-secondary">'+element._source.nom+'</a> '
            +'</strong> '
        +'</p> '

        +'<div class="d-flex justify-content-between mt-auto"> '
            +'<form action="add-panier" method="post">'
                +'<div class="input-group col-3 mr-2"> '
                    +'<input class="form-control" type="number" name="quantite" min="1" max="'+element._source.quantite_stock+'" value="1" /> '
                +'</div> <br> '
                +'<div class="col px-0"> '
                +'<input hidden name="num" value="'+element._source.num+'"/>'
                +'<input hidden name="nom" value="'+element._source.nom+'"/>'
                +'<input hidden name="prix" value="'+element._source.prix+'"/>'

                +'<button class="btn btn-outline-primary btn-block"> '
                    +'Add To Cart '
                    +'<i class="fa fa-shopping-basket" aria-hidden="true"></i> '
                +'</button> '
            +'</form>'
            +'</div> '
            +'<div class="ml-2"> '
                +'<button class="btn btn-outline-danger btn-block"> '
                    +'<i class="fa fa-trash"></i> '
                +'</button> '
            +'</div> '
        +'</div> '
        +'</div> '
        +'</div> '
        +'</div> '
    +'</div>'

    });
}



var buttonSearch = document.querySelector('.searchButton');
buttonSearch.addEventListener("click", 
    //search products according to the name and the price filter using elastic search with HTTP request 
    function sendSearchElasticByNameAndPrice() {
        let containerProduct = document.querySelector('#container-product');
        let searchContent = document.querySelector('#searchContent').value;
        document.querySelector('#searchContent').value='';
        containerProduct.innerHTML='';
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        fetch("http://127.0.0.1:9200/produits/_doc/_search", {
            method:"POST",
            headers: headers,
            mode : 'cors',
            body:  JSON.stringify(
                    {
                        "query": {
                            "bool": {
                                "must": [
                                {
                                    "match": {
                                        "nom": ""+searchContent+""
                                    }
                                },
                                {
                                    "range": {
                                        "prix" : {
                                            "lte" : Number(valueMaxPriceFilter.value),
                                            "gte" : Number(valueMinPriceFilter.value)
                                        }
                                    }
                                },
                                {
                                    "range": {
                                        "quantite_stock": {
                                            "gt" : Number(0)
                                        }
                                    }
                                },
                                ]
                            }
                        }
                    })
        })
        .then(response=>response.json())
        .then(data=>getAllProducts(data.hits.hits));
    }, 
false);


document.querySelector('#btnPriceFilter').addEventListener("click", 
    //return products according to the price filter using elastic search with HTTP request
    function sendSearchElasticByName() {
        let query = JSON.stringify(
            {
                "query": {
                    "bool": {
                        "must": [
                            {
                                "range" : {
                                    "prix" : {
                                        "lte" : Number(valueMaxPriceFilter.value),
                                        "gte" : Number(valueMinPriceFilter.value)
                                    }
                                }
                            },
                            {
                                "range": {
                                    "quantite_stock": {
                                        "gt" : Number(0)
                                    }
                                }
                            }
                        ]
                    }
                }
            }
        );
        document.querySelector('#container-product').innerHTML='';

        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        fetch("http://127.0.0.1:9200/produits/_doc/_search", {
            method:"POST",
            headers: headers,
            mode : 'cors',
            body:query      
        })
        .then(response=>response.json())
        .then(data=>getAllProducts(data.hits.hits));
    },
false);

</script>

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