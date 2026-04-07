<?php

namespace App\Helpers;

use App\Core\Session;
use Exception;

/**
 * Protection CSRF pour les formulaires de l'application.
 *
 * Génère et valide des tokens CSRF uniques par session pour protéger
 * contre les attaques Cross-Site Request Forgery.
 *
 * @package App\Helpers
 * @see Session
 */
class Csrf{

    private const SESSION_TOKEN_KEY = 'csrf_token';

    private const FIELD_NAME = 'csrf_token';

    /**
     * Génère un nouveau token CSRF unique et cryptographique.
     *
     * Stocke le token en session et le retourne pour l'affichage.
     * Utilisé lors du premier appel ou si token invalide/expiré.
     *
     * @return string Token CSRF hexadécimal (64 caractères)
     * @throws Exception Si Session::isStarted() échoue
     */
    public static function generateToken():string{
        Session::isStarted();

        $token = bin2hex(random_bytes(32));
        $_SESSION[self::SESSION_TOKEN_KEY] = [
            'token' => $token,
        ];
        return $token;
    }

    /**
     * Récupère le token CSRF actuel de la session.
     *
     * Génère un nouveau token si aucun token valide n'existe.
     *
     * @return string Token CSRF actuel (64 caractères hexadécimaux)
     * @throws Exception Si Session::isStarted() échoue
     */
    public static function getToken(): string{
        Session::isStarted();

        if(!self::isTokenValid()){
            return self::generateToken();
        }
        return $_SESSION[self::SESSION_TOKEN_KEY]['token'];
    }

    /**
     * Génère un champ HTML hidden CSRF prêt à utiliser.
     *
     * Exemple de sortie : `<input type="hidden" name="csrf_token" value="abc...">`
     *
     * @return string HTML du champ CSRF
     * @throws Exception
     */
    public static function field():string{
        $token = self::getToken();
        $fieldName = self::FIELD_NAME;

        return "<input type='hidden' value='{$token}' name='{$fieldName}'>";
    }

    /**
     * Vérifie si un token CSRF valide existe en session.
     *
     * @return bool true si token présent et valide, false sinon
     */
    public static function isTokenValid():bool{
        if(!isset($_SESSION[self::SESSION_TOKEN_KEY]['token'])){
            return false;
        }
        return true;
    }

}