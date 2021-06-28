<?php

namespace App\Controllers;

class Panier extends BaseController
{

	/**
	 * Page d'accueil du panier
	 * Retourne le panier associé à un utilisateur pour l'afficher sur la page
	 * 
	 */
	public function index()
	{
		$user = $this->getCurrentUser();
		if(empty($user)){
			return view('home');
		}
		
		$panier = $this->getCurrentPanier($user);

		return view('panier', $panier);
	}

	/**
	 * Supprime un article en appuyant sur le bouton remove
	 */
	public function deleteArticle()
	{
		$user = $this->getCurrentUser();
		$panier = $this->getCurrentPanier($user);

		$rem = $_POST['delete'];
		for ($i = 0; $i <= sizeof($panier) + 1; $i++) {
			if ($i == $rem) {
				unset($panier['data'][$i]);
				$panier['data'] = array_values($panier['data']);
				$this->cache->save($user, $panier);
				break;
			}
		}

		return view("panier", $panier);
	}


	/**
	 * Supprimer un article lorsque la quantité atteint 0
	 */
	public function deleteArticleQuantity($quantity_id)
	{
		$user = $this->getCurrentUser();
		$panier = $this->getCurrentPanier($user);

		for ($i = 0; $i <= sizeof($panier) + 1; $i++) {
			
			if ($i == $quantity_id) {
				unset($panier['data'][$i]);
				$panier['data'] = array_values($panier['data']);
				$this->cache->save($user, $panier);
			}
		}
	}

	/**
	 * retourne l'email de l'user actuellement connecté
	 */
	public function getCurrentUser() {
		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);
		return $user;
	}

	/**
	 * retourne le panier actuel de l'utilsateur connecte
	 */
	public function getCurrentPanier($user) {
		if ($this->cache->get($user) != null) {
			$panier = $this->cache->get($user);
		} else {
			$panier = array("data" => array());
		}

		return $panier;
	}


	/**
	 * Modifier la quantité avec les boutons plus et moins 
	 */

	public function changeQuantity($quantity_id)
	{
		$user = $this->getCurrentUser();
		$panier = $this->getCurrentPanier($user);

		if (isset($_POST['moins'])) {
			//BOUTON -
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i] == $panier["data"][$quantity_id]) {
					//s'il reste qu'une quantite et qu on appui sur moins on supprime l'article du panier
					if ($panier["data"][$i]["quantite"] == 1) {
						$this->deleteArticleQuantity($quantity_id);
						return view('panier');
					}
					$panier["data"][$quantity_id]["quantite"] =	$panier["data"][$quantity_id]["quantite"] - 1;
				}
			} 
		} else {
			//BOUTON +
			for ($i = 0; $i < sizeof($panier["data"]); $i++) {
				if ($panier["data"][$i] == $panier["data"][$quantity_id]) {
					$panier["data"][$quantity_id]["quantite"] =	$panier["data"][$quantity_id]["quantite"] + 1;
				}
			}
		}


		$this->cache->save($user, $panier, 300);
		return view('panier', $panier);
	}

	/**
	 * la commande est validé, on traduit le panier en une commande
	 */
	public function checkout()
	{
		$user = $this->getCurrentUser();
		$panier = $this->getCurrentPanier($user);
		$lastCommande = $this->mongo_db->select(array("id"))->order_by(array('id' => 'DESC'))->limit(1)->get("commandes");

		//si aucune commande n'avait ete fait le premiere id est 1
		$nextIdCommande = 1;
		if (!empty($lastCommande)) {
			$nextIdCommande = ($lastCommande[0]['id']) + 1;
		}

		//insertion de la commande
		$commandeInserted = $this->insertCommande($nextIdCommande, $this->cache->get('email'));

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
