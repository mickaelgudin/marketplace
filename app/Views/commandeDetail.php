<?php include "menu.php"; ?>

<div style="text-align:center;margin:50px 90px 50px 80px;">
   <?php echo ' <h2 class="mb-4" > Commande N°'.$data[0].' </h2>'; ?> 
    <table class="table table-hover">
    <thead>
        <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th class="text-center">Price</th>
        <th class="text-center">Total</th>
        </tr>
    </thead>
        <tbody>
        <?php  
        for($i = 1 ; $i<sizeOf($data);$i++){
           
            $id = $data[$i]['id'];
            $prixUnitaire = $data[$i]['prixUnitaire']; 
            $quantite=$data[$i]['quantite'];
            $numProduit=$data[$i]['numProduit'];
            $total = (int)$quantite * (int)$prixUnitaire;
          echo '<tr>
           <td class="col-sm-8 col-md-6">
               <div class="media">
               <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;"> </a>
               <div class="media-body">
               <h4 class="media-heading">Produit N° '.$id.'</h4>
               <h5 class="media-heading"> Product reference : '.$numProduit.'</h5>
               </div>
           </div></td>
           <td class="col-sm-1 col-md-1" style="text-align: center">
              <h5 class="media-heading"> '.$quantite.'</h5>
           </td>
           <td class="col-sm-1 col-md-1 text-center"><strong>'.$prixUnitaire.'€</strong></td>
           <td class="col-sm-1 col-md-1 text-center"><strong>'.$total.'€</strong></td>
       </tr>';  
        }
       ?>
        
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