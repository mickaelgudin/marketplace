<?php include "menu.php"; ?>




<div class="col-sm-12 col-md-10 col-md-offset-1">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th class="text-center">Price</th>
                <th class="text-center">Total</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($data)) {
                foreach ($data as $article) {

                    echo '  <tr>
                                <td class="col-sm-8 col-md-6">
                                    <div class="media">
                                        <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;"> </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="#">';

                    echo array_values($article)[0];

                    echo '</a></h4>
                                            <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                            <span>Status: </span><span class="text-warning"><strong>In Stock</strong></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1 col-md-1" style="text-align: center">
                                    <input type="number" class="form-control" value="';
                    echo array_values($article)[2];
                    echo '">
                                </td>
                                <td class="col-sm-1 col-md-1 text-center"><strong>';
                    echo array_values($article)[1] . "€";
                    echo '</strong></td>
                                <td class="col-sm-1 col-md-1 text-center"><strong>';
                    echo array_values($article)[1] * array_values($article)[2] . "€";
                    echo '</strong></td>
                                <td class="col-sm-1 col-md-1">
                                <form action="delete-article" method="post">
                                <input type="submit" class="btn btn-danger" name="delete"
                                value="Remove"/>
                                </form>

                
                                </td>
                            </tr>';
                }
            } else {
                echo "panier vide";
            }


            ?>


            </tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td>
                <h3>Total</h3>
            </td>
            <td class="text-right">
                <h3><strong><?php
                            $total = 0;
                            foreach ($data as $article) {

                                $total += array_values($article)[1] * array_values($article)[2];
                            }

                            echo $total . '€ </strong></h3>'; ?>
            </td>
            </tr>
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                    <button type="button" class="btn btn-default">
                        <span class="fa fa-shopping-cart"></span> Continue Shopping
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-success">
                        Checkout <span class="fa fa-play"></span>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>