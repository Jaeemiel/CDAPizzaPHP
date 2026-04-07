<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;
use Exception;

/**
 * Contrôleur d'authentification des utilisateurs.
 *
 * Gère l'affichage du formulaire de connexion, la validation des identifiants,
 * la tentative de connexion et la déconnexion.
 *
 * @package App\Controllers
 * @see Auth
 * @see Validator
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     *
     * Rend la vue `auth.login` sans layout (page complète).
     * Accessible aux utilisateurs non connectés uniquement.
     *
     * @return void
     * @throws Exception Si la vue est introuvable
     */
    public function login(): void
    {
        View::render("auth.login",[
            "messages" => Session::getAllFlashes(),
        ],false);
    }

    /**
     * Traite la tentative de connexion.
     *
     * 1. Valide les champs `login` et `password`
     * 2. En cas d'erreur : flash message + redirect /login
     * 3. En cas de succès : appelle Auth::attempt()
     *
     * @return void
     * @throws Exception En cas d'erreur de validation ou Auth
     */
    public function attemptLogin(): void
    {
        $validator = new Validator($_POST, [
            "login" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()){
            foreach ($validator->errors as $typeError) {
                foreach ($typeError as $error) {
                    Session::setFlash("danger", $error['message']);
                    $this->redirect("/login");
                    return;
                }
            }
        }
        $validate = $validator->validated;
        Auth::attempt($validate);

    }

    /**
     * Déconnecte l'utilisateur actuel.
     *
     * Appelle Auth::logout() et détruit la session utilisateur.
     * Redirige généralement vers la page d'accueil.
     *
     * @return void
     */
    public function logout(): void{
        Auth::logout();
    }
}