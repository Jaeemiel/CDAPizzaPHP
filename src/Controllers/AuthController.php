<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Validator;
use App\Core\View;

class AuthController extends Controller
{
    public function login(): void
    {
        View::render("auth.login");
    }

    public function attemptLogin(): void
    {
        $validator = new Validator($_POST, [
            "login" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()){
//            var_dump($validator->errors);
            foreach ($validator->errors as $typeError) {
//                var_dump($typeError);
                foreach ($typeError as $error) {
//                    var_dump($error['message']);
                    Session::setFlash("danger", $error['message']);
                    $this->redirect("/login");
                    return;
                }
            }
        }
        $validate = $validator->validated;
        Auth::attempt($validate);

    }

    public function logout(): void{
        Auth::logout();
    }
}