<?php

namespace App\Controllers;


class Panier extends BaseController
{
	public function index()
	{
		//activation de redis
		$this->cache = \Config\Services::cache();
		//$this->cache->delete("user");

		//mettre un tableau vide et remplir des que l'utilisateur ajoute un article depuis le catalogue
		$data = $this->cache->get('user');

		if(is_null($data)){
			$data = array(
				"data"=>array(
				
				)
			);
			echo  view("panier", $data);
			
		}else{
			echo view('panier', $data);
		}


		//$this->cache->save('user', $myArray, 300);
		//$data = $this->cache->get('user');
		

	}

	

}
