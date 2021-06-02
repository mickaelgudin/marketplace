<?php

namespace App\Controllers;


class Panier extends BaseController
{
	public function index()
	{
		//activation de redis
		$this->cache = \Config\Services::cache();
		//$this->cache->delete("user");


		$data = $this->cache->get('user');

		if (is_null($data)) {
			$data = array(
				"data" => array()
			);
			echo  view("panier", $data);
		} else {
			echo view('panier', $data);
		}


		//$this->cache->save('user', $myArray, 300);
		//$data = $this->cache->get('user');


	}

	public function deleteArticle()
	{
		$this->cache = \Config\Services::cache();
		var_dump("delete specific article");
		//$this->cache->delete('user');
		$this->index();
		

	}
}
