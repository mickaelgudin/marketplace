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
		$data = $this->cache->get('user');
		$rem = $_POST['delete'];
		for ($i = 0; $i <= sizeof($data)+1; $i++) {
			if(is_null($data)){
				$data = array(
					"data" => array()
				);
			}
			if ($i == $rem) {
				$test = "good";
				unset($data['data'][$i]);
				$data['data']=array_values($data['data']);
				$this->cache->save('user', $data);
				break;
			} else {
				$test = "rate";
			}
		}


		$this->index();
	}
}
