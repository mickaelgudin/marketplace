<?php include "menu.php"; ?>
<div class="container pt-5">
    <div class="row align-items-center justify-content-between">
        <div class="wrap col-md-3 col-5 text-right order-md-1">
            <div class="search">
                <input type="text" class="searchTerm" placeholder="What are you looking for?">
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

    </div>
</div>

<div class="container">
    <hr />
</div>

<div class="container">
    <div class="row">
    <?php
           
                foreach ($data as $article) {

       echo' <div class="col-md-4 mb-3">
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
                        <form action="';echo (!isset($_GET["add"])) ? "add-panier" : ''; 
                        
                        echo '" method="post">
                            <div>
                                <p class="h4 text-primary">'; 
                                echo array_values($article)[1];
                                echo'€</p>
                                <input type="hidden" name="prix" value="'; 
                                echo array_values($article)[1];
                                echo'" />
                            </div>
                            <div>
                                <a href="#" class="text-secondary lead" data-toggle="tooltip" data-placement="left" title="Compare">
                                    <i class="fa fa-line-chart" aria-hidden="true"></i>
                                </a>
                            </div>
                    </div>
                    <p class="mb-0">

                        <strong>
                            <a href="#" class="text-secondary">'; 
                             echo array_values($article)[0];
                             echo'</a>
                            <input type="hidden" name="title" value="';
                            
                            echo array_values($article)[0];
                            echo'" />
                        </strong>
                    </p>
                    <p class="mb-1">
                        <small>
                            <a href="#" class="text-secondary">Brands</a>
                        </small>
                    </p>

                    <div class="d-flex justify-content-between mt-auto">
                        <div class="input-group col-3 mr-2">
                            <input class="form-control" type="number" name="quantite" value="1" />
                        </div><br>
                        <div class="col px-0">
                            <input type="submit" class="btn btn-outline-primary btn-block" name="add" value="add to cart" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>'; }
        ?>

       
<div class="container">
    <hr />
</div>

</body>

</html>

<script>
    var buttonSearch = document.querySelector('.searchButton');
    buttonSearch.addEventListener("click",
        function sendSearchElastic() {
            //search products from elastic search avec une requete HTTP
            console.log('fd');
        },
        false);
</script>

<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans);

    body {
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

    .searchTerm:focus {
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