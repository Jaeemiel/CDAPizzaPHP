<?php

namespace App\Core;

use Exception;

/**
 * Gestionnaire de vues MVC avec layout optionnel.
 *
 * Rend les vues avec/sans layout principal (layouts/main.php).
 * Supporte les chemins pointés ('commandes.index') et données dynamiques.
 *
 * @see View::render()
 * @package App\Core
 */
class View {
    /**
     * Chemin absolu vers le répertoire des vues.
     *
     * @var string
     */
    public static string $view_path = "/var/www/html/views";

    /**
     * Chemin absolu vers le répertoire des layouts.
     *
     * @var string
     */
    public static string $layout_path = "/var/www/html/views/layouts";

    /**
     * Affiche une vue avec ou sans layout principal.
     *
     * - `$useLayout = true` : injecte la vue dans layouts/main.php
     * - `$useLayout = false` : affiche la vue complète seule (landing pages)
     *
     * @param string $view     Chemin relatif vers la vue (ex: 'home', 'commandes.index')
     * @param array  $data     Données à passer à la vue (extraites automatiquement)
     * @param bool   $useLayout [default=true] true=avec layout, false=vue seule
     * @return void
     * @throws Exception Si vue ou layout introuvable
     *
     * @example View::render('home', [], false);     // Landing sans layout
     * @example View::render('commandes/index');     // Avec layout
     */
    public static function render(string $view, array $data = [], bool $useLayout = true) {
        if (str_contains($view, ".")){
            $view = str_replace(".", "/", $view);
        }

        // SANS LAYOUT (landing)
        if (!$useLayout) {
            $view_file = self::$view_path . "/" . $view .".php";
            if (!file_exists($view_file)) {
                throw new Exception("la vue $view n'existe pas");
            }
            extract($data);
            require $view_file;
            return;
        }

        // AVEC LAYOUT (normal)
        $layout_path = self::$layout_path . "/main.php";
        if (file_exists($layout_path)) {
            $view_file = self::$view_path . "/" . $view .".php";
            if (file_exists($view_file)) {
                extract($data);
                ob_start();
                require $view_file;
                $content = ob_get_clean();
            }
            $data["messages"] = Session::getAllFlashes();
            $data["content"] = $content ?? "";
            $data["titre"] = $titre ?? "Pizza Manager";
            extract($data);
            require $layout_path;
        } else {
            throw new Exception("layout introuvable");
        }
    }
}