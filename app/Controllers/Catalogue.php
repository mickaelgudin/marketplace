<?php

namespace App\Controllers;

class Catalogue extends BaseController
{
	/**
	 * Affiche la page catalogue, lorsqu'on arrive sur le chemin /catalogue
	 */
	public function index()
	{
		$data = $this->catalogueItem();
		echo view('catalogue', $data);
	}

	/**
	 * Renvoi un tableau contenant des données fictives
	 */
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

		$nom_panier = array();
		for ($i = 0; $i < sizeof($panier['data']); $i++) {
			array_push($nom_panier, $panier['data'][$i]['nom']);
		}

		if (in_array($article["nom"], $nom_panier)) {
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i]["num"] == $article["num"]) {
					var_dump($panier["data"]);

					$panier["data"][$i]["quantite"] =	$panier["data"][$i]["quantite"] + $quantite;
				}
			}
		} else {
			array_push($panier['data'], $article);
		}

		$this->cache->save($user, $panier, 300);
		$data = $this->catalogueItem();

		echo view('catalogue', $data);
	}
}
