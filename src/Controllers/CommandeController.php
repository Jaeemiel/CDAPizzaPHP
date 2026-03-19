<?php

namespace App\Controllers;
use App\Core\View;
use App\Models\Commande;

class CommandeController extends \App\Core\Controller{

    /**
     * Liste toutes les catégories
     */
    public function index() : void{
        View::render("commandes.index",[
            "commandes"=>(new Commande())->findAll(),
        ]);
    }


    public function create() : void{

    }

    public function store() : void {

    }

    public function show(int $id) : void {
        View::render("commandes.show",[
            "commande"=>(new Commande())->find($id),
        ]);

    }

    public function edit (int $id) : void {

    }

    public function update (int $id) : void {

    }

    public function delete () : void {

    }

}