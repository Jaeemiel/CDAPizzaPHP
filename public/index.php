<?php

require_once (dirname(__DIR__) ."/autoloader.php");
require_once (dirname(__DIR__) ."/src/Helpers/functions.php");

/**
 * Pour mettre la BDD sur mon fuseau horaire.
 */
date_default_timezone_set('Europe/Paris');

use App\Controllers\AuthController;
use App\Controllers\ClientController;
use App\Controllers\CommandeController;
use App\Controllers\HomepageController;
use App\Controllers\PasswordController;
use App\Controllers\PizzaController;
use App\Core\Session;
use App\Core\Router;

Session::getInstance();

$router = new Router();
$router -> addMiddleware([
    "auth" => App\Core\Middlewares\AuthMiddlewares::class,
    "csrf" => App\Core\Middlewares\CsrfMiddlewares::class,
    "role" => App\Core\Middlewares\RoleMiddlewares::class,
    "password" => App\Core\Middlewares\PasswordMiddleware::class,

    // ajout des middlewares
]);


//$router
//   // ajout des routes
//    ->get("/", App\Controllers\HomepageController::class ."::home")
//
//    #Login
//    ->get("/login", AuthController::class . "::login")
//    ->post("/login", App\Controllers\AuthController::class . "::attemptlogin")
//    ->get("/logout", App\Controllers\AuthController::class . "::logout")
//
//    #First time
//    ->get("/password/change", App\Controllers\PasswordController::class . "::edit")->middleware("auth")
//    ->post("/password/change", App\Controllers\PasswordController::class . "::update")->middleware("auth")
//
//    #Commandes
//    ->get("/commandes",App\Controllers\CommandeController::class. "::index")->middleware("auth")->middleware("role:GUICHET,CUISINE")
//    ->get("/commandes/create", App\Controllers\CommandeController::class . "::create")->middleware("auth")->middleware("role:GUICHET")
//    ->post("/commandes/create", App\Controllers\CommandeController::class . "::store")->middleware("auth")->middleware("role:GUICHET")
//    ->get("/commandes/update/{id}", App\Controllers\CommandeController::class . "::edit")->middleware("auth")->middleware("role:GUICHET")
//    ->post("/commandes/update/{id}", App\Controllers\CommandeController::class . "::update")->middleware("auth")->middleware("role:GUICHET")
//    ->get("/commandes/show/{id}", App\Controllers\CommandeController::class ."::show")->middleware("auth")->middleware("role:GUICHET,CUISINE")
//    ->post("/commandes/{id}/etat", App\Controllers\CommandeController::class . "::updateEtat")->middleware("auth")->middleware("role:GUICHET,CUISINE")
//    ->post("/commandes/delete/{id}", App\Controllers\CommandeController::class ."::delete")->middleware("auth")->middleware("role:GUICHET")
//
//    #Clients
//    ->get("/clients",App\Controllers\ClientController::class. "::index")->middleware("auth")->middleware("role:GUICHET")
//    ->get("/clients/create", App\Controllers\ClientController::class . "::create")->middleware("auth")->middleware("role:GUICHET")
//    ->post("/clients/create", App\Controllers\ClientController::class . "::store")->middleware("auth")->middleware("role:GUICHET")
//    ->get("/clients/update/{id}", App\Controllers\ClientController::class . "::edit")->middleware("auth")->middleware("role:GUICHET")
//    ->post("/clients/update/{id}", App\Controllers\ClientController::class . "::update")->middleware("auth")->middleware("role:GUICHET")
//    ->get("/clients/show/{id}", App\Controllers\ClientController::class ."::show")->middleware("auth")->middleware("role:GUICHET")
//    ->post("/clients/delete/{id}", App\Controllers\ClientController::class ."::delete")->middleware("auth")->middleware("role:GUICHET")
//
//    #Pizzas
//    ->get("/pizzas",App\Controllers\PizzaController::class. "::index")->middleware("auth")->middleware("role:GERANT,CUISINE")
//    ->get("/pizzas/create", App\Controllers\PizzaController::class . "::create")->middleware("auth")->middleware("role:GERANT")
//    ->post("/pizzas/create", App\Controllers\PizzaController::class . "::store")->middleware("auth")->middleware("role:GERANT")
//    ->get("/pizzas/update/{id}", App\Controllers\PizzaController::class . "::edit")->middleware("auth")->middleware("role:GERANT")
//    ->post("/pizzas/update/{id}", App\Controllers\PizzaController::class . "::update")->middleware("auth")->middleware("role:GERANT")
//    ->get("/pizzas/show/{id}", App\Controllers\PizzaController::class ."::show")->middleware("auth")->middleware("role:GERANT,CUISINE")
//    ->post("/pizzas/{id}/stock", App\Controllers\PizzaController::class . "::updateStock")->middleware("auth")->middleware("role:GERANT,CUISINE")
//    ->post("/pizzas/delete/{id}", App\Controllers\PizzaController::class . "::delete")->middleware("auth")->middleware("role:GERANT")
//
//    ->run();

$router
    ->get("/", HomepageController::class ."::home")

    # Login
    ->get("/login", AuthController::class . "::login")
    ->post("/login", AuthController::class . "::attemptlogin")
    ->get("/logout", AuthController::class . "::logout")

    # First time
    ->get("/password/change", PasswordController::class . "::edit")->middleware("auth")
    ->post("/password/change", PasswordController::class . "::update")->middleware("auth");

# Commandes
$router->resource("commandes", CommandeController::class, [
    'all'    => ["auth"],
    'index'  => ["role:GUICHET,CUISINE"],
    'create' => ["role:GUICHET"],
    'store'  => ["role:GUICHET"],
    'show'   => ["role:GUICHET,CUISINE"],
    'edit'   => ["role:GUICHET"],
    'update' => ["role:GUICHET"],
    'delete' => ["role:GUICHET"],
]);

# Clients
$router->resource("clients", ClientController::class, [
    'all' => ["auth", "role:GUICHET"],
]);

# Pizzas
$router->resource("pizzas", PizzaController::class, [
    'all'    => ["auth"],
    'index'  => ["role:GERANT,CUISINE"],
    'create' => ["role:GERANT"],
    'store'  => ["role:GERANT"],
    'show'   => ["role:GERANT,CUISINE"],
    'edit'   => ["role:GERANT"],
    'update' => ["role:GERANT"],
    'delete' => ["role:GERANT"],
]);

# Routes spéciales
$router
    ->post("/commandes/{id}/etat", CommandeController::class . "::updateEtat")
    ->middleware("auth")->middleware("role:GUICHET,CUISINE")
    ->post("/pizzas/{id}/stock", PizzaController::class . "::updateStock")
    ->middleware("auth")->middleware("role:GERANT,CUISINE")
    ->run();