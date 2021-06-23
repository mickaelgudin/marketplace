<?php include "menu.php";?>
<div  style="text-align:center;margin:50px 80px 50px 60px;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Liste des Commandes validées</th>
                <th class="text-center">Prix</th>
                <th class="text-center"> Date </th>
            </tr>
        </thead>
        <tbody>
           <?php 
            foreach ($data as $commande){
                $id= $commande['id'];
                $prix = $commande['prixTotal'];
                $date = $commande['date'];
                echo '<tr>
                <td class="col-sm-8 col-md-6">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading"><a href="commandeDetail'.$id.'">Commande N°'. $id.' </a></h4>
                        </div>
                        
                    </div>
                </td>
                <td class="col-sm-1 col-md-1 text-center"><strong>'.$prix.'€</strong></td>
                <td class=" text-center"><strong>'.$date.'</strong></td>
            </tr>'; 
             }
             ?>
        </tbody>
    </table>
</div>