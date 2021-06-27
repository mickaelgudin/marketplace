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
function getQueryForPriceFilterAndPreviousName() {
    let valueMinPriceFilter = document.getElementById("valueMinPriceFilter");
    let valueMaxPriceFilter = document.getElementById("valueMaxPriceFilter");
    let valueFromSortedOption = document.getElementById("sorted-select").value;
    let previousSearchName = document.querySelector('#searchContent').value;
    let fieldToOrder = new Object();
    fieldToOrder[valueFromSortedOption.split('-')[0]] = {"order" : valueFromSortedOption.split('-')[1]};
    let matchName = {"match_all": {}};
    if(previousSearchName != "") {
        matchName = {"match": { "nom": String(previousSearchName)} };
    }

    let query = {
        "query": {
            "bool": {
                "must": [
                    matchName,
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
        },
        "sort" : [fieldToOrder]
    };
    
    return JSON.stringify(query);
}

//check the quantite for a given product to prevent quantities higher than the maximum available
function checkQuantite(event) {
    if(Number(event.value) > Number(event.max) ) {
        event.value = event.max;
    }
}

// elastic search query's result when page loaded
function retriveInitialData(){
    fetch(urlElasticSearch, getConfigForFetch(getQueryForAllProducts() ))
    .then(response=>response.json())
    .then(data=>showProductsFromResults(data.hits.hits));
}
//when we first load the price book
retriveInitialData();

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
        newProductItem = newProductItem.replaceAll('{{quantiteProduit}}', element._source.quantite_stock);
        containerProduct.innerHTML = containerProduct.innerHTML + newProductItem;
    });
}

function sendSearchElasticByPriceAndPreviousName() {
    document.querySelector('#container-product').innerHTML='';
    fetch(urlElasticSearch, getConfigForFetch(getQueryForPriceFilterAndPreviousName() ) )
    .then(response=>response.json())
    .then(data=>showProductsFromResults(data.hits.hits));
}

function resetFilters(){
    document.querySelector('#container-product').innerHTML='';
    retriveInitialData();
    document.getElementById("valueMinPriceFilter").value='1';
    document.getElementById("valueMaxPriceFilter").value='5000';
    document.getElementById("sorted-select").value='nom-asc';
    document.querySelector('#searchContent').value='';
}