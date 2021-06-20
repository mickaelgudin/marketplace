<?php

namespace App\Controllers;

class CommandeDetail extends BaseController
{
	public function index($idCommande = 0)
	{
		//récupérer le numéro de la commande
		echo $idCommande;
		///$parameter=$this->uri->segment(2);
		$data = $this->getCommandeItem();
		echo view('commandeDetail',$data);
	}
	public function getCommandeItem()
	{
		$data = array(
			"tabArticle" => array(
				"article1" => array(
					"nom" => "lunette",
					"quantité"=>3,
					"prix" => 3,
				),
				"article2" => array(
					"nom" => "montre",
					"quantité"=>2,
					"prix" => 10,
				)
			)
		);

		return $data;
	}
}
