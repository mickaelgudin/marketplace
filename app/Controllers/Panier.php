<?php

namespace App\Controllers;

use function PHPUnit\Framework\isNull;

class Panier extends BaseController
{

	/**
	 * Page d'accueil du panier
	 * Retourne le panier associé à un utilisateur pour l'afficher sur la page
	 * 
	 */
	public function index()
	{
		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);
		$data = $this->cache->get($user);

		if (is_null($data)) {
			$data = array(
				"data" => array()
			);
			return  view("panier", $data);
		} else {
			return view('panier', $data);
		}
	}

	/**
	 * Supprime un article en appuyant sur le bouton remove
	 */
	public function deleteArticle()
	{

		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);


		$data = $this->cache->get($user);

		$rem = $_POST['delete'];
		for ($i = 0; $i <= sizeof($data) + 1; $i++) {
			if (is_null($data)) {
				$data = array(
					"data" => array()
				);
			}
			if ($i == $rem) {
				$test = "good";
				unset($data['data'][$i]);
				$data['data'] = array_values($data['data']);
				$this->cache->save($user, $data);
				break;
			} else {
				$test = "rate";
			}
		}


		$this->index();
	}


	/**
	 * Supprimer un article lorsque la quantité atteint 0
	 */
	public function deleteArticleQuantity()
	{

		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);


		$data = $this->cache->get($user);

		$quantity_id = $_POST['quantity_id'];
		for ($i = 0; $i <= sizeof($data) + 1; $i++) {
			if (is_null($data)) {
				$data = array(
					"data" => array()
				);
			}
			if ($i == $quantity_id) {
				$test = "good";
				unset($data['data'][$i]);
				$data['data'] = array_values($data['data']);
				$this->cache->save($user, $data);
			} else {
				$test = "rate";
			}
		}


		$this->index();
	}

	/**
	 * Modifier la quantité avec les boutons plus et moins 
	 */

	public function changeQuantity()
	{


		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);

		if ($this->cache->get($user) != null) {
			$panier = $this->cache->get($user);
		} else {
			$panier = array(
				"data" => array()
			);
		}
		$quantity_id = $_POST['quantity_id'];

		if (isset($_POST['plus'])) {
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i] == $panier["data"][$quantity_id]) {

					$panier["data"][$quantity_id]["quantite"] =	$panier["data"][$quantity_id]["quantite"] + 1;
				}
			}
		}

		if (isset($_POST['moins'])) {
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i] == $panier["data"][$quantity_id]) {
					if ($panier["data"][$i]["quantite"] == 1) {
						$this->deleteArticleQuantity();
						exit();
					}
					$panier["data"][$quantity_id]["quantite"] =	$panier["data"][$quantity_id]["quantite"] - 1;
				}
			}
		}



		$this->cache->save($user, $panier, 300);
		$this->index();
	}

	/**
	 * la commande est validé, on traduit le panier en une commande
	 */
	public function checkout()
	{
		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);
		$panier = $this->cache->get($user);
		$lastCommande = $this->mongo_db->select(array("id"))->order_by(array('id' => 'DESC'))->limit(1)->get("commandes");

		//si aucune commande n'avait ete fait le premiere id est 1
		$nextIdCommande = 1;
		if (!empty($lastCommande)) {
			$nextIdCommande = ($lastCommande[0]['id']) + 1;
		}

		//insertion de la commande
		$commandeInserted = $this->insertCommande($nextIdCommande, $user_start);

		//insere des lignes de commandes(a partir des articles du panier)
		if (!empty($commandeInserted)) {
			$hasBeenInserted = $this->insertLignesDeCommande($panier["data"], $nextIdCommande);
			if ($hasBeenInserted == false) {
				return redirect()->to('/public/panier?error=les lignes de commande n\'ont pas ete cree');
			}

			//on vide le panier et on confirme la creation de la commande a l'utilisateur
			$this->cache->save($user, array());
			return redirect()->to('/public/panier?success=la commande a bien ete cree');
		} else {
			return redirect()->to('/public/panier?error=la commande a echoue');
		}
	}

	/**
	 * insertion de la nouvelle commande
	 */
	private function insertCommande($nextIdCommande, $user_start)
	{
		$connectedUser =  $this->mongo_db->select(array("id"))->where(array("email" => $user_start))->limit(1)->get("utilisateurs");

		//traduction du panier en commande
		$newCommande = array(
			'id' => intval($nextIdCommande),
			'prixTotal' => intval($_POST['totalPrix']),
			'date' => new \MongoDB\BSON\UTCDateTime(time() * 1000),
			'idUtilisateur' => intval($connectedUser[0]['id'])
		);

		return $this->mongo_db->insert('commandes',  $newCommande);
	}

	/**
	 * insertion des lignes de commande
	 */
	private function insertLignesDeCommande($lignesDuPanier, $idCommande)
	{
		$lignesDeCommande = array();

		foreach ($lignesDuPanier as $article) {
			array_push(
				$lignesDeCommande,
				array(
					'numProduit' => $article['num'],
					'quantite' => intval($article["quantite"]),
					'prixUnitaire' => intval($article["prix"]),
					'idCommande' => intval($idCommande)
				)
			);
		}

		return $this->mongo_db->batch_insert('ligneDeCommande', $lignesDeCommande);
	}
}
