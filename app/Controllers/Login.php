<?php

namespace App\Controllers;

class Login extends BaseController
{

	public function index()
	{
		return view('login');
	}

	public function check() {
		//activation de redis
		$this->cache= \Config\Services::cache();
        $this->cache->save('d', 'bar', 100000);
	    return view('login');
	}
}
