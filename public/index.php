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


$router -> addMiddleware([
    "auth" => App\Core\Middlewares\AuthMiddlewares::class,
    "csrf" => App\Core\Middlewares\CsrfMiddlewares::class,

    // ajout des middlewares
]);
$router
   // ajout des routes
    ->get("/", App\Controllers\HomepageController::class ."::home")
//    ->get("/users/create", App\Controllers\UserController::class . "::create")
//    ->post("/users/create", App\Controllers\UserController::class . "::store")
//    ->get("/users/terms", App\Controllers\UserController::class . "::terms")
//    ->get("/users/privacy", App\Controllers\UserController::class . "::privacy")

//    ->get("/login", App\Controllers\AuthController::class . "::login")
//    ->post("/login", App\Controllers\AuthController::class . "::attemptlogin")
//    ->get("/logout", App\Controllers\AuthController::class . "::logout")
    ->get("/commandes",App\Controllers\CommandeController::class. "::index")
    ->get("/commandes/create", App\Controllers\CommandeController::class . "::create")
    ->post("/commandes/create", App\Controllers\CommandeController::class . "::store")
    ->get("/commandes/update/{id}", App\Controllers\CommandeController::class . "::edit")
    ->post("/commandes/update/{id}", App\Controllers\CommandeController::class . "::update")
    ->get("/commandes/show/{id}", App\Controllers\CommandeController::class ."::show")
    ->post("/commandes/{id}/etat", App\Controllers\CommandeController::class . "::updateEtat")
    ->post("/commandes/delete/{id}", App\Controllers\CommandeController::class ."::delete")



    ->get("/clients",App\Controllers\ClientController::class. "::index")
    ->get("/clients/create", App\Controllers\ClientController::class . "::create")
    ->post("/clients/create", App\Controllers\ClientController::class . "::store")
    ->get("/clients/update/{id}", App\Controllers\ClientController::class . "::edit")
    ->post("/clients/update/{id}", App\Controllers\ClientController::class . "::update")
    ->get("/clients/show/{id}", App\Controllers\ClientController::class ."::show")
    ->post("/clients/delete/{id}", App\Controllers\ClientController::class ."::delete")



    ->get("/pizzas",App\Controllers\PizzaController::class. "::index")
    ->get("/pizzas/create", App\Controllers\PizzaController::class . "::create")
    ->post("/pizzas/create", App\Controllers\PizzaController::class . "::store")
    ->get("/pizzas/update/{id}", App\Controllers\PizzaController::class . "::edit")
    ->post("/pizzas/update/{id}", App\Controllers\PizzaController::class . "::update")
    ->get("/pizzas/show/{id}", App\Controllers\PizzaController::class ."::show")
    ->post("/pizzas/delete/{id}", App\Controllers\PizzaController::class . "::delete")


    ->run();

//$user = (new Pizza()) -> find(1) ->getNameRole();
