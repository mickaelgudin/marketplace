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
                    <option value="">Popular</option>
                    <option value="">Name</option>
                </select>  
            </div>


            <div class="slidecontainer">
                <input type="range" min="1" max="5000" value="500" class="slider" id="priceFilter">
                <label for="price-min" id="price-min-label">Price < or == to : </label>
                <input type="number" data-type="range" name="price-min" id="valuePriceFilter" value="500" min="1" max="5000">
                <button id = "btnPriceFilter" class="btn btn-outline-primary btn-block">Apply</button>
            </div>

            
            
            
        </div>
    </div>

    <div class="container">
    <hr />
    </div>

    <div id="container-product" class="container">
    <div class="row">

        <div class="col-md-4 mb-3">
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
            <img src="https://picsum.photos/700/550" class="card-img-top" alt="Product">
            </a>
            <div class="card-body px-2 pb-2 pt-1">
            <div class="d-flex justify-content-between">
                <div>
                <p class="h4 text-primary">$129,99</p>
                </div>
                <div>
                <a href="#" class="text-secondary lead" data-toggle="tooltip" data-placement="left" title="Compare">
                    <i class="fa fa-line-chart" aria-hidden="true"></i>
                </a>
                </div>
            </div>
            <p class="mb-0">
                <strong>
                <a href="#" id="product-title" class="text-secondary"></a>
                </strong>
            </p>

            <div class="d-flex justify-content-between mt-auto">
                <div class="input-group col-3 mr-2">
                    <input class="form-control" type="number" name="quantite" value="1" />
                </div><br>
                <div class="col px-0">
            
                <button class="btn btn-outline-primary btn-block">
                    Add To Cart 
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                </button>
                </div>
                <div class="ml-2">
                    <button class="btn btn-outline-danger btn-block">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            </div>
        </div>
        </div>

        
    </div>
    </div>

    <div class="container">
    <hr />
    </div>

    </body>
</html>


<script>
    
    
       
    let priceFilter = document.getElementById("priceFilter");
    let valuePriceFilter = document.getElementById("valuePriceFilter");
    valuePriceFilter.value = priceFilter.value;

    fetch("http://127.0.0.1:9200/produits/_doc/_search")
    .then(response=>response.json())
    .then(data=>getAllProducts(data.hits.hits));

    
    function getAllProducts(resp){
        resp.forEach(function(element){
            let title = document.querySelector('#product-title');
            let containerProduct = document.querySelector('#container-product');
            //insertAdjacentHTML('afterend', )
            
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
        +'<p class="h4 text-primary">$129,99</p> '
        +'</div> '
        +'<div> '
        +'<a href="#" class="text-secondary lead" data-toggle="tooltip" data-placement="left" title="Compare"> '
            +'<i class="fa fa-line-chart" aria-hidden="true"></i> '
        +'</a> '
        +'</div> '
    +'</div> '
    +'<p class="mb-0"> '
        +'<strong> '
        +'<a href="#" id="product-title" class="text-secondary"></a> '
        +'</strong> '
    +'</p> '

    +'<div class="d-flex justify-content-between mt-auto"> '
        +'<div class="input-group col-3 mr-2"> '
            +'<input class="form-control" type="number" name="quantite" value="1" /> '
        +'</div> <br> '
        +'<div class="col px-0"> '
        +'<button class="btn btn-outline-primary btn-block"> '
            +'Add To Cart '
            +'<i class="fa fa-shopping-basket" aria-hidden="true"></i> '
        +'</button> '
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
//);
            //title.innerHTML = element._source.nom;
            //console.log(element._source);
        });
    }
    
    

    var buttonSearch = document.querySelector('.searchButton');
    buttonSearch.addEventListener("click", 
        function sendSearchElastic() {
            //search products from elastic search avec une requete HTTP
            let containerProduct = document.querySelector('#container-product');
            containerProduct.innerHTML='';
            
            fetch("http://127.0.0.1:9200/produits/_doc/_search", {
                method:"GET",
                    "query": {
                        "match": {
                        "nom": ""+document.querySelector('#searchContent').innerHTML+""
                        }
                    }
                
            })
            .then(response=>response.json())
            .then(data=>getAllProducts(data.hits.hits));
            console.log('fd');
        }, 
    false);

     
    priceFilter.oninput = function() {
        valuePriceFilter.value = this.value;
    }

    valuePriceFilter.oninput = function() {
        priceFilter.value = this.value;
    }


    
        document.querySelector('#btnPriceFilter').addEventListener("click", 
            function sendSearchElastic() {
                console.log(valuePriceFilter.value);
                let query = JSON.stringify(
                        {
                            "query": {
                              "range" : {
                                    "prix" : {
                                        "lt" : Number(valuePriceFilter.value)
                                    }
                                }
                            }
                        }
                );
                    console.log(query); 
                document.querySelector('#container-product').innerHTML='';
               fetch("http://127.0.0.1:9200/produits/_doc/_search", {
                    method:"POST",
                    query      
                })
                .then(response=>response.json())
                .then(data=>console.log(data.hits.hits));//getAllProducts(data.hits.hits));
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

</style>