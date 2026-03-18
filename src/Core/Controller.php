<?php
namespace App\Core;
/**
 * Classe de base pour tous les controllers de l'application
 */
class Controller{

    public string $view_path ;

    /**
     * Initialise le controlleur
     * Configure le chemin vers le repertoire des vues en utilisant le repertoire parent
     */
    public function __construct(){
        $this->view_path = dirname(__DIR__) . "/Views";
    }

    /**
     * Redirige l'utilisateur vers une URL spécifique
     * @param $path
     * @return void
     */
    public function redirect($path){
        header("Location: {$path}");
        exit;
    }
}