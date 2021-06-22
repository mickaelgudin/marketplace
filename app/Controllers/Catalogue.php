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
		$this->cache = \Config\Services::cache();
		$user_start = $this->cache->get('email');

		if(empty($user_start)) {
			return view('home');
		}

		$user = str_replace('@', "key", $user_start);

		if ($this->cache->get($user) != null) {
			$panier = $this->cache->get($user);
		} else {
			$panier = array(
				"data" => array()
			);
		}

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
					$panier["data"][$i]["quantite"] =	$panier["data"][$i]["quantite"] + $quantite;
				}
			}
		} else {
			array_push($panier['data'], $article);
		}

		$this->cache->save($user, $panier, 300);
		return view('catalogue');
	}
}
