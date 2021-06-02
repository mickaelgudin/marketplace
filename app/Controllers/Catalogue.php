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
		if ($data = $this->cache->get('user') != null) {
			$data = $data = $this->cache->get('user');
		} else {
			$data = array(
				"data" => array()
			);
		}
	
		$prix=$_POST['prix'];
		$title=$_POST['title'];
		$quantite=$_POST['quantite'];

		$article = array(
			"nom" => $title,
			"prix" => $prix,
			"quantite" => $quantite
		);


		array_push($data['data'], $article);
		$this->cache->save('user', $data, 300);
		var_dump($this->cache->get('user'));
		return view('catalogue');
	}
}
