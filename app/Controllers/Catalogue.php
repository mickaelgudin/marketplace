<?php

namespace App\Controllers;

class Catalogue extends BaseController
{
	public function index()
	{
		return view('catalogue');
	}

	public function addPanier()
	{


		$this->cache = \Config\Services::cache();

		/**
		 * tableau exemple 
		 * $data = array(
		 *	"data"=>array(
		 *	"article1" => array(
		 *		"nom" => "lunette",
		 *		"prix" => 3,
		 *		"quantite" => 3
		 *	),
		 *	"article2" => array(
		 *		"nom" => "montre",
		 *		"prix" => 10,
		 *		"quantite" => 1
		 *	))
		 *);*/
		if ($data = $this->cache->get('user') != null) {
			$data = $data = $this->cache->get('user');
		} else {
			$data = array(
				"data" => array()
			);
		}

		$article = array(
			"nom" => "test",
			"prix" => 3,
			"quantite" => 3
		);


		array_push($data['data'], $article);
		$this->cache->save('user', $data, 300);
		var_dump($this->cache->get('user'));
		return view('catalogue');
	}
}
