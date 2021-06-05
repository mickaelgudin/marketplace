<?php

namespace App\Controllers;

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


		$results = $this->mongo_db->where(array('username' => $_POST['username'], 
		 										'password' => $_POST['password']) )->get('utilisateurs');


		$login = '';
		if(!empty($results)) {
			$_POST['login'] = $_POST['username'];
			$this->cache->save($_POST['username'], $_POST['username'], 300);
			return view('login', array($_POST['login']) );
		} 

		return redirect()->to('/public/login?error=login');
	}

	public function createAccount() {
		if($this->request->getMethod() == 'get') {
			return redirect()->to('/public/login?signup=true');
		}

		$credentials = array('username' => $_POST['username'], 
						'password' => $_POST['password']);

		$results = $this->mongo_db->where($credentials)->get('utilisateurs');

		if(!empty($results)) {
			return redirect()->to('/public/login?error=signup');
		}

		$this->mongo_db->insert('utilsateurs', $credentials);

		return redirect()->to('/public/login?success=signup');
	}

}
