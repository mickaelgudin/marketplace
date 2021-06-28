<?php include "menu.php"; ?>
<?php
    $commande = $data[0][0];
    $produits = $data[1];
?>

<div style="text-align:center;margin:50px 90px 50px 80px;">
   <?php echo ' <h2 class="mb-4" > Commande N°'.$commande["id"].' </h2>'; ?> 
    <table class="table table-hover">
    <thead>
        <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th class="text-center">Prix unitaire</th>
        <th class="text-center">Prix total</th>
        </tr>
    </thead>
        <tbody>

        <?php foreach($produits as $produit) : ?>
            <tr>
                <td class="col-sm-8 col-md-6">
                    <div class="media">
                    <a class="thumbnail pull-left" href="#"> <img class="media-object" src="<?=$produit["numProduit"]?>.png" style="width: 72px; height: 72px;"> </a>
                    <div class="media-body">
                    <h5 class="media-heading"> Référence : <?=$produit["numProduit"]?></h5>
                    </div>
                </div></td>
                <td class="col-sm-1 col-md-1 text-center"><?=$produit["quantite"]?></td>
                <td class="col-sm-1 col-md-1 text-center"><?=$produit["prixUnitaire"]?>€</td>
                <td class="col-sm-1 col-md-1 text-center"><?=((int)$produit["quantite"] * (int)$produit["prixUnitaire"])?>€</td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td class="col-sm-8 col-md-6"></td>
                <td class="col-sm-1 col-md-1" style="text-align: center"></td>
                <td class="col-sm-1 col-md-1 text-center"><h5 class="media-heading">Total </h5></td>
                <td class="col-sm-1 col-md-1 text-center"><strong><?=$commande["prixTotal"]?>€</strong></td>
            </tr>
        </tbody>
    </table>
    <button type="button" class="btn btn-success"> <a  class="nav-link" href="commande">
    Retour à la liste des commandes </a>
    </button>
</div>
<style>
    a {
        text-decoration: none;
        color:white;
    }
    a:hover {
        color:white;
    }
</style>