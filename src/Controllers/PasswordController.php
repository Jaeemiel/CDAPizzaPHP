<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;

class PasswordController extends Controller{

    public function edit(): void{
        View::render("auth.password",[],false);
    }

    public function update(): void{
        $validator = new Validator($_POST,[
            "password" => "required|min:8|password",
            "password_confirmation" => "required|same:password",
        ]);

        if($validator->fails()){
            Session::setFlash("danger", "Mot de passe invalide.");
            $this->redirect("/password/change");
            return;
        }

        if ($_POST['password'] !== $_POST['password_confirmation']) {
            Session::setFlash("danger", "Les mots de passe ne correspondent pas.");
            $this->redirect("/password/change");
            return;
        }

        $user = Auth::user();
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->must_change_password = 0;
        $user->password_changed_at = date('Y-m-d H:i:s');
        $user->save();

        Session::setFlash("success", "Mot de passe modifié avec succès.");
        $this->redirect("/commandes");
    }
}