<?php

namespace App\Controllers;

class Login extends BaseController
{

	public function index()
	{
		return view('login');
	}

	public function check() {
		$results = $this->mongo_db->where(array('username' => 'username'))->get('utilisateurs');
		
		//var_dump($results);

		$statusLogin = '';
		if(!empty($results)) {
			$statusLogin = "connected";
		} else {
			$statusLogin = "not connected";
		}

		//$_POST['connected'] = $statusLogin;

	    return view('login');
	}

	public function createAccount() {
		//configurer mongodb
	}
}
