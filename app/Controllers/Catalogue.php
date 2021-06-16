<?php

namespace App\Controllers;

class Catalogue extends BaseController
{
	public function index()
	{


		$data = $this->catalogueItem();
		echo view('catalogue', $data);
	}

	public function catalogueItem()
	{
		$data = array(
			"data" => array(
				"article1" => array(
					"nom" => "lunette",
					"prix" => 3,
				),
				"article2" => array(
					"nom" => "montre",
					"prix" => 10,
				)
			)
		);

		return $data;
	}

	public function addPanier()
	{

		$this->cache = \Config\Services::cache();

		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);

		if ($this->cache->get($user) != null) {
			$panier = $this->cache->get($user);
		} else {
			$panier = array(
				"data" => array()
			);
		}

		$prix = $_POST['prix'];
		$title = $_POST['title'];
		$quantite = $_POST['quantite'];

		$article = array(
			"nom" => $title,
			"prix" => $prix,
			"quantite" => $quantite
		);

		//avant de push l'article dans le panier, parcourir le panier d'abord 
		//verifier si 1er item du panier, deuxieme item du panier correspond à l'item du catalogue
		//modifier la quantité du panier
		
		$nom_panier = array();
		for ($i = 0; $i < sizeof($panier['data']); $i++) {
			array_push($nom_panier, $panier['data'][$i]['nom']);
		}

		if (in_array($article["nom"], $nom_panier)) {
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i]["nom"] == $article["nom"]) {
					$panier["data"][$i]["quantite"] =	$panier["data"][$i]["quantite"] + $quantite;
				}
			}
		} else {
			array_push($panier['data'], $article);
		}

		//	}
		//1 = lunette = lunette 

		$this->cache->save($user, $panier, 300);
		$data = $this->catalogueItem();

		echo view('catalogue', $data);
	}
}
