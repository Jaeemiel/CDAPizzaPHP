<?php


#var_dump(dirname(__DIR__) ."/autoloader.php");

require_once (dirname(__DIR__) ."/autoloader.php");
require_once (dirname(__DIR__) ."/src/Helpers/functions.php");

/**
 * Pour mettre la BDD sur mon fuseau horaire.
 */
date_default_timezone_set('Europe/Paris');

use App\Core\Session;
use App\Core\Wizardvalidator;
\App\Core\Session::getInstance();

$router = new App\Core\Router();
//echo("Guichet: ");
//var_dump(password_hash("guichet1",PASSWORD_DEFAULT));
//echo(" Cuisine: ");
//var_dump(password_hash("cuisine1",PASSWORD_DEFAULT));
$router -> addMiddleware([
    "auth" => App\Core\Middlewares\AuthMiddlewares::class,
    "csrf" => App\Core\Middlewares\CsrfMiddlewares::class,
    "role" => \App\Core\Middlewares\RoleMiddlewares::class,

    // ajout des middlewares
]);
$router
   // ajout des routes
    ->get("/", App\Controllers\HomepageController::class ."::home")
//    ->get("/users/create", App\Controllers\UserController::class . "::create")
//    ->post("/users/create", App\Controllers\UserController::class . "::store")
//    ->get("/users/terms", App\Controllers\UserController::class . "::terms")
//    ->get("/users/privacy", App\Controllers\UserController::class . "::privacy")

    ->get("/login", App\Controllers\AuthController::class . "::login")
    ->post("/login", App\Controllers\AuthController::class . "::attemptlogin")
    ->get("/logout", App\Controllers\AuthController::class . "::logout")

    ->get("/commandes",App\Controllers\CommandeController::class. "::index")->middleware("auth")->middleware("role:GUICHET,CUISINE")
    ->get("/commandes/create", App\Controllers\CommandeController::class . "::create")->middleware("auth")->middleware("role:GUICHET")
    ->post("/commandes/create", App\Controllers\CommandeController::class . "::store")->middleware("auth")->middleware("role:GUICHET")
    ->get("/commandes/update/{id}", App\Controllers\CommandeController::class . "::edit")->middleware("auth")->middleware("role:GUICHET")
    ->post("/commandes/update/{id}", App\Controllers\CommandeController::class . "::update")->middleware("auth")->middleware("role:GUICHET")
    ->get("/commandes/show/{id}", App\Controllers\CommandeController::class ."::show")->middleware("auth")->middleware("role:GUICHET,CUISINE")
    ->post("/commandes/{id}/etat", App\Controllers\CommandeController::class . "::updateEtat")->middleware("auth")->middleware("role:GUICHET,CUISINE")
    ->post("/commandes/delete/{id}", App\Controllers\CommandeController::class ."::delete")->middleware("auth")->middleware("role:GUICHET")



    ->get("/clients",App\Controllers\ClientController::class. "::index")->middleware("auth")->middleware("role:GUICHET")
    ->get("/clients/create", App\Controllers\ClientController::class . "::create")->middleware("auth")->middleware("role:GUICHET")
    ->post("/clients/create", App\Controllers\ClientController::class . "::store")->middleware("auth")->middleware("role:GUICHET")
    ->get("/clients/update/{id}", App\Controllers\ClientController::class . "::edit")->middleware("auth")->middleware("role:GUICHET")
    ->post("/clients/update/{id}", App\Controllers\ClientController::class . "::update")->middleware("auth")->middleware("role:GUICHET")
    ->get("/clients/show/{id}", App\Controllers\ClientController::class ."::show")->middleware("auth")->middleware("role:GUICHET")
    ->post("/clients/delete/{id}", App\Controllers\ClientController::class ."::delete")->middleware("auth")->middleware("role:GUICHET")



    ->get("/pizzas",App\Controllers\PizzaController::class. "::index")->middleware("auth")->middleware("role:GERANT,CUISINE")
    ->get("/pizzas/create", App\Controllers\PizzaController::class . "::create")->middleware("auth")->middleware("role:GERANT")
    ->post("/pizzas/create", App\Controllers\PizzaController::class . "::store")->middleware("auth")->middleware("role:GERANT")
    ->get("/pizzas/update/{id}", App\Controllers\PizzaController::class . "::edit")->middleware("auth")->middleware("role:GERANT")
    ->post("/pizzas/update/{id}", App\Controllers\PizzaController::class . "::update")->middleware("auth")->middleware("role:GERANT")
    ->get("/pizzas/show/{id}", App\Controllers\PizzaController::class ."::show")->middleware("auth")->middleware("role:GERANT,CUISINE")
    ->post("/pizzas/{id}/stock", App\Controllers\PizzaController::class . "::updateStock")->middleware("auth")->middleware("role:GERANT,CUISINE")
    ->post("/pizzas/delete/{id}", App\Controllers\PizzaController::class . "::delete")->middleware("auth")->middleware("role:GERANT")


    ->run();
