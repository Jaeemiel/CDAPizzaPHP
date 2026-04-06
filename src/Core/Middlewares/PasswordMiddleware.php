<?php

namespace App\Core\Middlewares;

class PasswordMiddleware implements InterfaceMiddlewares
{
    public function handle(): void
    {
        $user = Auth::user();

        // Si l'utilisateur doit changer son mot de passe
        // et n'est pas déjà sur la page de changement
        if ($user->must_change_password &&
            $_SERVER['REQUEST_URI'] !== '/password/change') {
            header("Location: /password/change");
            exit;
        }
    }
}