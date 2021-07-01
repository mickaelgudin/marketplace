<?php

namespace App\Controllers;

class Login extends BaseController
{

	public function index()
	{
		return view('login');
	}

	/**
	 * verification de la tentative de connexion
	 * le cas écheant un message d'erreur est afficher
	 */
	public function check() {
		if($this->request->getMethod() == 'get') {
			return redirect()->to('/public/login');
		}

		$results = $this->mongo_db->where(array('email' => $_POST['email'], 'password' => $_POST['password']) )
								  ->get('utilisateurs');
		//on vérifie que le compte existe bien						  
		if(!empty($results)) {
			//on crée une variable dans redis en utilisant les méthodes de cache de CodeIgniter
			$this->cache->save('email', $_POST['email'], 7200); 
			return redirect()->to('/public/catalogue');
		} 

		return redirect()->to('/public/login?error=vérifier vos identiants');
	}

	/**
	 * Création d'un nouveau utilisateur
	 * si l'email existe deja pour un autre utilisateur on retourne une erreur
	 */
	public function createAccount() {
		if($this->request->getMethod() == 'get') {
			return redirect()->to('/public/login?signup=true');
		}

		$results = $this->mongo_db->where(array('email' => $_POST['email']) )->get('utilisateurs');

		$lastUser = $this->mongo_db->select(array("id"))->order_by(array('id' => 'DESC'))->limit(1)->get("utilisateurs");
		$nextUserId = 1;
		if (!empty($lastUser)) {
			$nextUserId = ($lastUser[0]['id']) + 1;
		}

		//si un utilisateur a déjà cette email on retourne une erreur
		if(!empty($results)) {
			return redirect()->to('/public/login?error=le compte existe déjà');
		}

		//sinon on crée un nouvel utilisateurs dans mongodb
		$this->mongo_db->insert('utilisateurs', array('id' => $nextUserId, 'email' => $_POST['email'], 'password' => $_POST['password']) );

		return redirect()->to('/public/login?success=le compte a été crée');
	}

	/**
	 * suppression des données de l'utilisateur dans redis 
	 * $_POST['login'] est defini dans le BaseController (pour avoir accès au nom de l'utilsateur connecté sur tous les controllers)
	 * @return view
	*/ 
	public function logout() {

		//lorsqu'on se deconnecte on supprime le panier de l'utilisateur
		$user_start = $this->cache->get('email');
		$user = str_replace('@', "key", $user_start);
		$this->cache->delete($user);

		$this->cache->delete('email');
		
		return redirect()->to('/public/');
	}
	

}
