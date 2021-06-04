<?php

namespace App\Controllers;

class Home extends BaseController
{
	
	public function index()
	{

		/*
		$results = $this->mongo_db->select()->get('bios');
		print_r($results);
		*/

		return view('home');
	}
}
