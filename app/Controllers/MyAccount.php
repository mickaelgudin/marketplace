<?php

namespace App\Controllers;

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
            $newEmailAlreadyAnAccount = !empty($this->mongo_db->where(array("email" => $_POST['email']))->limit(1)->get("utilisateurs"));
            
            //le nouveau email renseigné doit ne pas être déjà présent pour un utilisateur dans mongodb
            if($newEmailAlreadyAnAccount == false) {
                $setUpdate['email'] = $_POST['email'];
            } else {
                return redirect()->to('/public/myaccount?error=l\'email correspond deja a un compte');
            }
        }

        //le mot de passe a ete modifie
        if($connectedUser[0]['password'] == $_POST['old-password'] && !empty($_POST['new-password']) ) {
            $setUpdate['password'] = $_POST['new-password'];
        } else if($_POST['old-password'] != $connectedUser[0]['password'] && !empty($_POST['new-password'] ) ) {
            return redirect()->to('/public/myaccount?error=votre ancien mot de passe est incorrect');
        }

        //on met tout a jour
        $this->mongo_db->where(array('email'=>$connectedUser[0]['email']))->set($setUpdate)->update('utilisateurs');
        $this->cache->save('email', $setUpdate['email'], 7200); 
        return redirect()->to('/public/myaccount?success=vos informations ont ete modifies');
    }
}
