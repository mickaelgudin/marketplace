<?php

namespace App\Controllers;

use function PHPUnit\Framework\isEmpty;

class MyAccount extends BaseController
{
	public function index()
	{
        $user_start = $this->cache->get('email');
        $connectedUser =  $this->mongo_db->select(array('email'))->where(array("email" => $user_start))->limit(1)->get("utilisateurs");
        return view('myaccount', array('data' => $connectedUser));
	}

    /*
    * Mise a jour des infos du compte de l user connecte
    */
    public function updateAccount() {
        $user_start = $this->cache->get('email');
        $connectedUser =  $this->mongo_db->where(array("email" => $user_start))->limit(1)->get("utilisateurs");
        $setUpdate = array('email' => $connectedUser[0]['email'], 'password' => $connectedUser[0]['password']);

        //l'email a ete modifie
        if(!empty($_POST['email']) && $_POST['email'] !== $connectedUser[0]['email'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $setUpdate['email'] = $_POST['email'];
        }

        //le mot de passe a ete modifie
        if($connectedUser[0]['password'] == $_POST['old-password'] && !empty($_POST['new-password']) ) {
            $setUpdate['password'] = $_POST['new-password'];
        }

        //on met tout a jour
        $this->mongo_db->where(array('email'=>$connectedUser[0]['email']))->set($setUpdate)->update('utilisateurs');
        $this->cache->save('email', $setUpdate['email'], 7200); 
        return view('myaccount', array('data' => $connectedUser)); 
    }
}
