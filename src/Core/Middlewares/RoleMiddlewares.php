<?php

namespace App\Core\Middlewares;

use App\Core\Auth;
use App\Core\Session;

class RoleMiddlewares implements InterfaceMiddlewares {

    public ?array $expected_role = null;
    public function __construct($expected_role){
        $this->expected_role = explode(",",$expected_role);
    }

    public function handle() : void {
        $user = Auth::user();
        if (!in_array($user->role,$this->expected_role)) {

            Session::setFlash("danger", "Vous n'avez pas les droits pour accéder à cette page.");
            header("Location: /");
            exit;
        }
    }
}