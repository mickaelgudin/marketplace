<?php include "menu.php"; ?>
<?php $totalPrix=0 ?>



<div class="col-sm-12 col-md-10 col-md-offset-1">
    <?php if(isset($_GET['error'])) : ?>
        <div class="alert alert-danger" role="alert"><?=$_GET['error']?></div>
    <?php endif; ?>
    <?php if(isset($_GET['success'])) : ?>
        <div class="alert alert-success" role="alert"><?=$_GET['success']?></div>
    <?php endif; ?>

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
                $i = 0;
                foreach ($data as $article) {
                    $totalPrix += array_values($article)[3] * array_values($article)[2];
            ?>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            <?php echo array_values($article)[1]; ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </td>

                        <td class="col-sm-1 col-md-1 text-center"><strong>

                                <form action="change-quantity" method="post">
                                    <input type="submit" name="plus" value="+">
                                    <input type="submit" name="moins" value="-">
                                    <input type="hidden" class="btn btn-danger" name="quantity_id" value="<?php echo $i; ?>" />
                                </form>
                                <?php
                                echo array_values($article)[3];
                                ?>
                            </strong></td>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>
                                <?php
                                echo array_values($article)[2];
                                ?>€</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>
                                </strong></td>
                        <td class="col-sm-1 col-md-1">
                            <form action="delete-article" method="post">
                                <input type="hidden" class="btn btn-danger" name="delete" value="<?php echo $i; ?>" />
                                <input type="submit" class="btn btn-danger" name="delete" value="remove" />


                            </form>


                        </td>
                    </tr>

            <?php
                    $i++;
                }
            } 

            ?>


            </tr>

            <?php if(empty($data) ): ?>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td>
                        <h3 style="color:gray">Le panier est vide</h3>
                    </td>
                    <td></td>
                </tr>
            <?php endif;?>

            <td> </td>
            <td> </td>
            <td> </td>
            <td>
                <h3>Total</h3>
            </td>
            <td class="text-left">
                <h3><strong> <?=$totalPrix?> €</strong></h3>
            </td>
            </tr>
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                    <button type="button" class="btn btn-default">
                        <span class="fa fa-shopping-cart"></span> <a href="catalogue">Continue Shopping</a>
                    </button>
                </td>
                <td>
                    <!--On ne peut pas commander si il n'y a pas d'article dans le panier-->
                    <?php if(!empty($data) ): ?>
                        <form action="Panier/checkout" method="POST">
                            <input hidden type="number" name="totalPrix" value="<?=$totalPrix?>"/>
                            <button type="submit" class="btn btn-success">
                                Commander <span class="fa fa-play"></span>
                            </button>
                        </form>
                    <?php endif;?>
                </td>
            </tr>
        </tbody>
    </table>
</div>