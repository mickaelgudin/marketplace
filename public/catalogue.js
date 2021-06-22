var urlElasticSearch = "http://127.0.0.1:9200/produits/_doc/_search";

//get basic config for elastic search queries
function getConfigForFetch(query) {
    let headers = new Headers();
    headers.append('Content-Type', 'application/json');

    return {
        method:"POST",
        headers: headers,
        mode : 'cors',
        body:query      
    };
}

//query to display all product, when we first load the pricebook
function getQueryForAllProducts() {
    return JSON.stringify(
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
}

//query to display products with price filter from user input
function getQueryForPriceFilter() {
    let valueMinPriceFilter = document.getElementById("valueMinPriceFilter");
    let valueMaxPriceFilter = document.getElementById("valueMaxPriceFilter");

    return JSON.stringify(
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
}

//query to display products with price and name filters from user input
function getQueryForNameAndPriceFilter() {
    let valueMinPriceFilter = document.getElementById("valueMinPriceFilter");
    let valueMaxPriceFilter = document.getElementById("valueMaxPriceFilter");
    let containerProduct = document.querySelector('#container-product');
    let searchContent = document.querySelector('#searchContent').value;
    document.querySelector('#searchContent').value='';
    containerProduct.innerHTML='';

    return JSON.stringify(
    {   "query": {
            "bool": {
                "must": [
                {
                    "match": {
                        "nom": String(searchContent)
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
}


//check the quantite for a given product to prevent quantities higher than the maximum available
function checkQuantite(event) {
    if(Number(event.value) > Number(event.max) ) {
        event.value = event.max;
    }
}

// elastic search query's result when page loaded
fetch(urlElasticSearch, getConfigForFetch(getQueryForAllProducts() ))
.then(response=>response.json())
.then(data=>showProductsFromResults(data.hits.hits));

//SHOW PRODUCTS FROM ELASTIC SEARCH QUERY SEARCH
function showProductsFromResults(resp){
    if(resp.length == 0) {
        let containerProduct = document.querySelector('#container-product');
        containerProduct.innerHTML = '<h2 style="color: gray;">Pas de produits disponibles</h2>';
    }

    resp.forEach(function(element){
        //ajout d'un produit dans le dom (en utilisant le template disponible dans la view catalogue.php)
        let title = document.querySelector('#product-title');
        let containerProduct = document.querySelector('#container-product');
        let productItem = document.querySelector('#product-item');
        let newProductItem = productItem.innerHTML.replaceAll("{{prixProduit}}", element._source.prix);
        newProductItem = newProductItem.replaceAll('{{numProduit}}', element._source.num);
        newProductItem = newProductItem.replaceAll('{{nomProduit}}', element._source.nom);
        containerProduct.innerHTML = containerProduct.innerHTML + newProductItem;
    });
}



var buttonSearch = document.querySelector('.searchButton');
//search products according to the name and the price filter using elastic search with HTTP request 
buttonSearch.addEventListener("click", 
    function sendSearchElasticByNameAndPrice() {
        
        fetch(urlElasticSearch, getConfigForFetch(getQueryForNameAndPriceFilter() ) )
        .then(response=>response.json())
        .then(data=>showProductsFromResults(data.hits.hits));
    }, 
false);

//return products according to the price filter using elastic search with HTTP request
document.querySelector('#btnPriceFilter').addEventListener("click", 
    function sendSearchElasticByName() {
        document.querySelector('#container-product').innerHTML='';
        fetch(urlElasticSearch, getConfigForFetch(getQueryForPriceFilter() ) )
        .then(response=>response.json())
        .then(data=>showProductsFromResults(data.hits.hits));
    },
false);