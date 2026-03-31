<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Enum\Etat_commande;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Pizza;
use App\Services\ReductionService;
use Exception;

class CommandeController extends Controller{

    /**
     * Liste toutes les commandes
     * @return void
     * @throws Exception
     */
    public function index() : void{
        $commandes = (new Commande())->findAll();
        $etatsCommandes = array_map(
            fn($c) => Etat_commande::from($c->etat),
            $commandes
        );

        View::render("commandes.index",[
            "commandes"=>$commandes,
            "etatsCommandes"=>$etatsCommandes,
        ]);
    }

    /**
     * Applique et notifie les réductions
     * @param Commande $commande
     * @param Client $client
     * @return void
     */
    private function applyNotifyDiscount(Commande $commande, Client $client): void
    {
        $reductionService = new ReductionService();
        $reductions = $reductionService->appliqueReductions($commande, $client);

        if (!empty($reductions)) {
            Session::setFlash("info", "Réductions appliquées : " . implode(", ", $reductions));
        }
    }

    /**
     * Page du formulaire de création : GET
     * @return void
     * @throws Exception
     */
    public function create() : void{

        View::render("commandes.form",[
            "clients"=>(new Client())->findAll(),
            "commande"=>(new Commande()),
            "pizzas"=>(new Pizza())->findAll(),
            "etats"=>Etat_commande::cases(),
            "etatDefaut"=>Etat_commande::PAYER,
        ]);
    }

    /**
     * Page du formulaire de création : POST
     * @return void
     * @throws Exception
     */
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

                }
            }
            Session::set("old", $_POST);
            $this->redirect("/commandes/create");
            return;
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
        $commande->syncPizzas($_POST['pizzas']??[]);

        $commande = (new Commande())->find($commande->id);
        $this->applyNotifyDiscount($commande,$client);


        Session::setFlash("success", "La commande a bien été créé.");
        $this->redirect("/commandes");
    }

    /**
     * Page de la commande
     *
     * @param mixed $id
     * @return void
     * @throws Exception
     */
    public function show(mixed $id) : void {
        $id = intval($id);
        $commande = (new Commande())->find($id);

        if ($commande === null) {
            Session::setFlash("danger", "Commande introuvable.");
            $this->redirect("/commandes");
            return;
        }
        $reduction = new ReductionService();

        $etat = Etat_commande::from($commande->etat);
        View::render("commandes.show",[
            "commande" => $commande,
            "etats" => Etat_commande::cases(),
            "etat" => $etat,
            "etatSuivant" => $etat->suivant(),
            "reductions" => $reduction->getReductions($commande, $commande->client())
        ]);

    }

    /**
     * Page du formulaire de modification : GET
     *
     * @param mixed $id
     * @return void
     * @throws Exception
     */
    public function edit (mixed $id) : void {
        $id = intval($id);
        $commande = (new Commande())->find($id);

        if ($commande === null) {
            Session::setFlash("danger", "Commande introuvable.");
            $this->redirect("/commandes");
            return;
        }

        $clients = (new Client())->findAll();
        View::render("commandes.form",[
            "commande" => $commande,
            "clients" => $clients,
            "pizzas" => (new Pizza())->findAll(),
            "pizzasCommande" => $commande->getCommandePizza(),
            "etats" => Etat_commande::cases(),
        ]);
    }

    /**
     * Change l'état d'une commande
     *
     * @param mixed $id
     * @return void
     * @throws Exception
     */
    public function updateEtat(mixed $id): void
    {
        $id = intval($id);
        $commande = (new Commande())->find($id);

        if($commande === null){
            Session::setFlash("danger", "Commande introuvable.");
            $this->redirect("/commandes");
            return;
        }

        $etat = Etat_commande::from($commande->etat);
        $etatSuivant = $etat->suivant();

        if ($etatSuivant === null) {
            Session::setFlash("danger", "La commande est déjà au dernier état.");
            $this->redirect("/commandes");
            return;
        }

        $commande->etat = $etatSuivant->value;
        $commande->save();

        Session::setFlash("success", "État mis à jour : " . $etatSuivant->label());
        $this->redirect("/commandes");
    }


    /**
     * Page du formulaire de modification : POST
     *
     * @param mixed $id
     * @return void
     * @throws Exception
     */
    public function update (mixed $id) : void {
        $id = intval($id);
        $commande = (new Commande())->find($id);

        if ($commande === null) {
            Session::setFlash("danger", "Commande introuvable.");
            $this->redirect("/commandes");
            return;
        }

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

                }
            }
            Session::set("old", $_POST);
            $this->redirect("/commandes/update/{$id}");
            return;
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
        $commande->syncPizzas($_POST['pizzas'] ?? []);

        // Rechargement pour récupérer le montant recalculé par le trigger SQL
        $commande = (new Commande())->find($commande->id);

        $this->applyNotifyDiscount($commande,$client);

        Session::setFlash("success", "La commande a bien été modifié.");
        $this->redirect("/commandes");
    }


//    /**
//     * Page du formulaire de création : POST
//     * @return void
//     * @throws Exception
//     */
//    public function delete (mixed $id) : void {
//        $id = intval($id);
//        $commande = (new Commande())->find($id);
//
//    }





}