<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Models\Client;
use App\Models\Commande;
use App\Services\ReductionService;

class CommandeController extends Controller{

    /**
     * Liste toutes les commandes
     */
    public function index() : void{
        View::render("commandes.index",[
            "commandes"=>(new Commande())->findAll(),
        ]);
    }

    private function applyNotifyDiscount(Commande $commande, Client $client): void
    {
        $reductionService = new ReductionService();
        $reductions = $reductionService->appliqueReductions($commande, $client);

        if (!empty($reductions)) {
            Session::setFlash("info", "Réductions appliquées : " . implode(", ", $reductions));
        }
    }

    public function create() : void{
        View::render("commandes.form",[
            "clients"=>(new Client())->findAll(),
            "commande"=>(new Commande()),
        ]);
    }

    public function store() : void {
        $validator = new Validator($_POST,[
            "commentaire" => "nullable",
            "client_id" => "exists:client",
        ]);

        if($validator->fails()){
            foreach ($validator->errors as $typeError){
//                var_dump($typeError);
                foreach ($typeError as $error){
//                    var_dump($error['message']);
                    Session::setFlash("danger",$error['message']);

                    Session::set("old", $_POST);
                    $this->redirect("/commandes/create");
                    return;}
            }
        }

        $validate = $validator->validated;

        $commande = new Commande();
        $commande->fill($validate);
        $client = (new Client())->find($commande->client_id);

        if ($client === null) {
            Session::setFlash("danger", "Client introuvable.");
            $this->redirect("/commandes/create");
            return;
        }

        $commande->save();

        $this->applyNotifyDiscount($commande,$client);

        Session::setFlash("success", "La commande a bien été créé.");
        $this->redirect("/commandes");
    }

    public function show(mixed $id) : void {
        $id = intval($id);
        View::render("commandes.show",[
            "commande"=>(new Commande())->find($id),
        ]);

    }

    public function edit (mixed $id) : void {
        $id = intval($id);
        $commande = (new Commande())->find($id);
        $clients = (new Client())->findAll();
        View::render("commandes.form",[
            "commande"=>$commande,
            "clients"=>$clients,
        ]);
    }

    public function update (mixed $id) : void {
        $id = intval($id);
        $commande = (new Commande())->find($id);
        $validator = new Validator($_POST,[

            "commentaire" => "nullable",
            "client_id" => "exists:client",
        ]);

        if($validator->fails()){
            foreach ($validator->errors as $typeError){
//                var_dump($typeError);
                foreach ($typeError as $error){
//                    var_dump($error['message']);
                    Session::setFlash("danger",$error['message']);

                    Session::set("old", $_POST);
                    $this->redirect("/commandes/update/{$id}");
                    return;}
            }
        }

        $validate = $validator->validated;

        $commande->fill($validate);
        $client = (new Client())->find($commande->client_id);
        if ($client === null) {
            Session::setFlash("danger", "Client introuvable.");
            $this->redirect("/commandes/update/{$id}");
            return;
        }

        $commande->save();

        // Rechargement pour récupérer le montant recalculé par le trigger SQL
        $commande = (new Commande())->find($commande->id);

        $this->applyNotifyDiscount($commande,$client);

        Session::setFlash("success", "La commande a bien été modifié.");
        $this->redirect("/commandes");
    }

//    public function delete (mixed $id) : void {
//        $id = intval($id);
//        $commande = (new Commande())->find($id);
//
//    }

}