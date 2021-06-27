<?php

namespace App\Controllers;

class CommandeDetail extends BaseController
{
	public function index($idCommande = 0)
	{
		$user_email= $this->cache->get('email');
		if(empty($user_email)){
			return view('home');
		}
		
		$dataArray = array("data"=>$this->getCommandeItem($idCommande));
		return view('commandeDetail',$dataArray);
	}
	public function getCommandeItem($idCommande = 0)
	{
		$data = $this->mongo_db->where(array('idCommande' =>(int)$idCommande) )
								  ->get('ligneDeCommande');
								 
		$commande = $this->mongo_db->where(array('id' =>(int)$idCommande) )->get('commandes'); 

		$dataArray = array();
		array_push($dataArray, $commande);

		$products = array();
		foreach($data as $j){
			array_push($products, array('numProduit'=>$j['numProduit'], 'prixUnitaire'=> $j['prixUnitaire'] , 'quantite'=>$j['quantite'],'numProduit'=>$j['numProduit']));
		}

		array_push($dataArray, $products);
		return $dataArray;
	}
}
