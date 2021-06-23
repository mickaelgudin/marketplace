<?php

namespace App\Controllers;

class Commande extends BaseController
{
	public function index()
	{   
		$user_email= $this->cache->get('email');
		if(!empty($user_email)){
			$results = $this->mongo_db->where(array('email' => $user_email) )->get('utilisateurs');
			$idUser = $results[0]['id'];
			$dataArray = array("data"=>$this->getCommandes($idUser));
			echo view('commande',$dataArray);
		}
		else{
			$dataArray = array("data"=>array());
			echo view('commande',$dataArray);
		}
	}

	public function getCommandes($idUser)
	{
		$data = $this->mongo_db->where(array('idUtilisateur' =>(int)$idUser) )
								  ->get('commandes');
								  
		$dataArray = array();
		foreach($data as $j){
			$utcdatetime =$j['date'];
			$datetime = $utcdatetime->toDateTime();
			array_push($dataArray, array('id'=> $j['id'], 'prixTotal'=> $j['prixTotal'] , 'date'=>$datetime->format('Y-m-d h:i:sa')));
		}
		return $dataArray;
	}
}
