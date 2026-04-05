<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Core\View;
use App\Core\Validator;
use App\Enum\EtatCommande;
use App\Enum\Role;
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
        $role = Role::from(Auth::user()->role);

        $commandesFiltrer = array_values(array_filter($commandes,
            fn($c) => match ($role){
                Role::CUISINE => $c->etat === EtatCommande::PREPARATION->value,
                Role::GUICHET => $c->etat !== EtatCommande::LIVRER->value,
                default => false,
            }
        ));

        $etatsCommandes = array_map(
            fn($c) => EtatCommande::from($c->etat),
            $commandesFiltrer
        );

        View::render("commandes.index",[
            "commandes"=>$commandesFiltrer,
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
            $last = count($reductions)-1;
            $message = "Reductions appliquées: ";
            foreach ($reductions as $i=>$reduction){
                $message .= $reduction->label().(($i < $last) ? ", ": ".");
            }
            Session::setFlash("info", $message);
        }
    }

    /**
     * Page du formulaire de création : GET
     * @return void
     * @throws Exception
     */
    public function create() : void{

        View::render("commandes.form",[
            "clients" => (new Client())->findAll(),
            "clientId" => $_GET['client_id'] ?? null, // ← présélection
            "commande" => (new Commande()),
            "pizzas" => (new Pizza())->findAvailable(),
            "etats" => EtatCommande::cases(),
            "etatDefaut" => EtatCommande::PAYER,
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
        $validate['commentaire'] = (!empty($_POST['commentaire']) ? $_POST['commentaire'] : null);
        $validate['etat'] = EtatCommande::PAYER->value;
        $validate['montant_final'] = null;
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
        $role = Role::from(Auth::user()->role);
        $etat = EtatCommande::from($commande->etat);

        View::render("commandes.show",[
            "commande" => $commande,
            "etats" => EtatCommande::cases(),
            "etat" => $etat,
            "etatSuivant" => $etat->suivant(),
            "peutChangerEtat" => $role->peutChangerEtat($etat),
            "reductions" => $reduction->getReductions($commande, $commande->client())
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

        $etat = EtatCommande::from($commande->etat);
        $etatSuivant = $etat->suivant();
        $role = Role::from(Auth::user()->role);

        if ($etatSuivant === null) {
            Session::setFlash("danger", "La commande est déjà au dernier état.");
            $this->redirect("/commandes");
            return;
        }

        if(!$role->peutChangerEtat($etat)){
            Session::setFlash("danger", "Action non autorisée.");
            $this->redirect("/commandes");
            return;
        }

        $commande->etat = $etatSuivant->value;
        $commande->save();

        Session::setFlash("success", "État mis à jour : " . $etatSuivant->label());
        $this->redirect("/commandes");
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
            "clientId" => null,
            "pizzas" => (new Pizza())->findAvailable(),
            "pizzasCommande" => $commande->getCommandePizza(),
            "etats" => EtatCommande::cases(),
        ]);
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
        $validate['commentaire'] = (!empty($_POST['commentaire']) ? $_POST['commentaire'] : null);
        $validate['etat'] = (!empty($_POST['etat']) ? $_POST['etat'] : EtatCommande::PAYER->value);
        $validate['montant_final'] = null;
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


    /**
     * Supprime une commande
     * @param mixed $id
     * @return void
     */
    public function delete(mixed $id): void
    {
        $id = intval($id);
        $commande = (new Commande())->find($id);

        if ($commande === null) {
            Session::setFlash("danger", "Commande introuvable.");
            $this->redirect("/commandes");
            return;
        }

        $commande->syncPizzas([]);
        $commande->delete($id);

        Session::setFlash("danger", "La commande a bien été supprimée.");
        $this->redirect("/commandes");
    }





}