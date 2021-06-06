<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use \Datetime;

class Login extends BaseController
{

	public function index()
	{
		return view('login');
	}

	public function check() {
		if($this->request->getMethod() == 'get') {
			return redirect()->to('/public/login');
		}

		$results = $this->mongo_db->where(array('username' => $_POST['username'], 'password' => $_POST['password']) )
								  ->get('utilisateurs');

		if(!empty($results)) {
			$this->cache->save('username', $_POST['username'], 7200);
			return redirect()->to('/public/login?success=vous êtes connecté');
		} 

		return redirect()->to('/public/login?error=login');
	}

	public function createAccount() {
		if($this->request->getMethod() == 'get') {
			return redirect()->to('/public/login?signup=true');
		}

		$credentials = array('username' => $_POST['username'], 'password' => $_POST['password']);				

		$results = $this->mongo_db->where($credentials)->get('utilisateurs');

		if(!empty($results)) {
			return redirect()->to('/public/login?error=le compte existe déjà');
		}

		$this->mongo_db->insert('utilisateurs', $credentials );

		return redirect()->to('/public/login?success=le compte a été crée');
	}

	/**
	 * suppression des données de l'utilisateur dans redis 
	 * $_POST['login'] est defini dans le BaseController (pour avoir accès au nom de l'utilsateur connecté sur tous les controllers)
	 * @return view
	*/ 
	public function logout() {
		$this->cache->delete('username');
		return redirect()->to('/public/');
	}
}
