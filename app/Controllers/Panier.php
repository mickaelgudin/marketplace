<?php

namespace App\Controllers;


class Panier extends BaseController
{
	public function index()
	{
		//activation de redis
		$this->cache = \Config\Services::cache();
		//$this->cache->delete("d");

		//mettre un tableau vide et remplir des que l'utilisateur ajoute un article depuis le catalogue
		$data = array(
			"data"=>array(
			"article1" => array(
				"nom" => "lunette",
				"prix" => 3,
				"quantite" => 3
			),
			"article2" => array(
				"nom" => "montre",
				"prix" => 10,
				"quantite" => 1
			))
		);



		//$this->cache->save('user', $myArray, 300);
		//$data = $this->cache->get('user');
		echo view('panier', $data);

	}

	

}
