<?php

namespace App\Core;

use App\Enum\Role;
use App\Models\Utilisateur;

class Auth{
    public static ?Utilisateur $user = null;

    public static function check(): bool{
        return Session::has('user');
    }

    public static function user(){
        if (!self::$user) {
            self::$user = (new Utilisateur())->find(self::id());
            return self::$user;
        }
        return self::$user;
    }

    public static function id(): ?int{
        if (Session::has('user')) {
            return Session::get("user");
        }
        return null;
    }

    public static function attempt($validated): void{
        $user = (new Utilisateur())->findBy("login", $validated["login"], true);
        if ($user) {
            if (password_verify($validated["password"], $user->password)) {
                self::login($user);
                return;
            }
        }
        Session::setFlash("error", "combo mail/mdp erroné !");
        header("location: /login");
        exit;
    }

    public static function login(Utilisateur $user): void{
        Session::setUser($user->id);
        Session::setFlash("success", "Connexion réussie");

        if ($user->must_change_password) {
            Session::setFlash("warning", "Veuillez changer votre mot de passe avant de continuer.");
            header("location: /password/change");
            exit;
        }

        $role = Role::from($user->role);
        $redirect = match($role) {
            Role::GUICHET => "/commandes",
            Role::CUISINE => "/commandes",
            Role::GERANT  => "/pizzas",
        };

        header("location: $redirect");
        exit;
    }

    public static function logout(): void {
        Session::destroy();
        Session::getInstance(); // recrée une session propre
        Session::setFlash("success", "Vous êtes bien déconnecté");
        header("Location: /login");
        exit;
    }
}
