<?php

namespace App\Controllers;

class Catalogue extends BaseController
{
	public function index()
	{

		
		$data = $this->catalogueItem();
		echo view('catalogue', $data);
		
	}

	public function catalogueItem()
	{
		$data = array(
			"data"=>array(
			"article1" => array(
				"nom" => "lunette",
				"prix" => 3,
			),
			"article2" => array(
				"nom" => "montre",
				"prix" => 10,
			))
		);

		return $data;
	}

	public function addPanier()
	{

		$this->cache = \Config\Services::cache();
		if ($this->cache->get('user') != null) {
			$panier = $this->cache->get('user');
		} else {
			$panier = array(
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
		

		
		array_push($panier['data'], $article);
		$this->cache->save('user', $panier, 300);
		//var_dump($this->cache->get('user'));

		$data = $this->catalogueItem();

		echo view('catalogue', $data);
	}
}
