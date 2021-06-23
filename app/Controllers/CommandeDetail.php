<?php

namespace App\Controllers;

class CommandeDetail extends BaseController
{
	public function index($idCommande = 0)
	{
		$dataArray = array("data"=>$this->getCommandeItem($idCommande));
		echo view('commandeDetail',$dataArray);
	}
	public function getCommandeItem($idCommande = 0)
	{
		$data = $this->mongo_db->where(array('idCommande' =>(int)$idCommande) )
								  ->get('ligneDeCommande');
								  
		$dataArray = array();
		array_push($dataArray,$idCommande);
		foreach($data as $j){
			array_push($dataArray, array('id'=> $j['id'], 'prixUnitaire'=> $j['prixUnitaire'] , 'quantite'=>$j['quantite'],'numProduit'=>$j['numProduit']));
		}
		return $dataArray;
	}
}
