<?php

namespace App\Controllers;

class Catalogue extends BaseController
{
	/**
	 * Affiche la page catalogue, lorsqu'on arrive sur le chemin /catalogue
	 */
	public function index()
	{
		$this->cache = \Config\Services::cache();
		$connectedUsername = $this->cache->get('email');

		if(!empty($connectedUsername) ) {
			return view('catalogue');
		} else {
			return view('home');
		}
	}

	/**
	 * Ajoute un article du catalogue au panier
	 * Si l'article existe déjà dans le panier, la quantité augmente
	 * Le panier correspond à un utilisateur
	 * Le panier se supprime 5 min après l'ajout du dernier article
	 */
	public function addPanier()
	{
		$user_start = $this->cache->get('email');
		if(empty($user_start)) {
			return view('home');
		}

		$user = str_replace('@', "key", $user_start);

		//si l'utilisateur déjà un panier alors on le prend
		$panier = ($this->cache->get($user) != null) ?  $this->cache->get($user): array("data" => array() );
		
		$article = array(
			"num" => $_POST['num'],
			"nom" => $_POST['nom'],
			"prix" => $_POST['prix'],
			"quantite" => $_POST['quantite']
		);

		$quantite = $_POST['quantite'];

		$num_panier = array();
		for ($i = 0; $i < sizeof($panier['data']); $i++) {
			array_push($num_panier, $panier['data'][$i]['num']);
		}

		if (in_array($article["num"], $num_panier)) {
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i]["num"] == $article["num"]) {
					//la quantite de l'article deja présent n'est pas mise à jour si le stock n'est pas suffisant
					if($_POST["quantite_stock"] < $panier["data"][$i]["quantite"] + $quantite) {
						break;
					}

					$panier["data"][$i]["quantite"] =	$panier["data"][$i]["quantite"] + $quantite;
				}
			}
		} else {
			//l'article est ajouté la premiere fois seulement si la quantite selectionne est suffisante
			if($_POST["quantite_stock"] >= $quantite ) {
				array_push($panier['data'], $article);
			}
		}

		$this->cache->save($user, $panier, 300);
		return view('catalogue');
	}
}
