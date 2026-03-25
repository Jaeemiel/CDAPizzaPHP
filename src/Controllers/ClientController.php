<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;
use App\Models\Client;
use Exception;

class ClientController extends Controller{

    /**
     * Liste toutes les clients
     * @return void
     * @throws Exception
     */
    public function index() : void{
        View::render("clients.index",[
            "clients"=>(new Client())->findAll(),
        ]);
    }


    /**
     * Page du formulaire de création : GET
     * @return void
     * @throws Exception
     */
    public function create () : void{
        View::render("clients.form");
    }

    /**
     * Page du formulaire de création : POST
     * @return void
     * @throws Exception
     */
    public function store () : void{
        $validator = new Validator($_POST,[
            "nom" => "required",
            "prenom" => "required",
            "telephone" => "required|min:10|max:12",
            "rue" => "required",
            "code_postal" => "required|max:5",
            "ville" => "required",
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
            $this->redirect("/clients/create");
            return;
        }

        $validate = $validator->validated;

        $client = new Client();
        $client->fill($validate);

        $client->save();

        Session::setFlash("success", "Le client a bien été créé.");

        // Redirection vers la création de commande car le client
        // est créé dans le flux de création de commande
        $this->redirect("/commandes/create");

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
        $client = (new Client())->find($id);

        if ($client === null) {
            Session::setFlash("danger", "Client introuvable.");
            $this->redirect("/clients");
            return;
        }

        View::render("clients.form",[
            "client"=>$client,
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
        $client = (new Client())->find($id);

        if ($client === null) {
            Session::setFlash("danger", "Client introuvable.");
            $this->redirect("/clients");
            return;
        }

        $validator = new Validator($_POST,[
            "nom" => "required",
            "prenom" => "required",
            "telephone" => "required|min:10|max:12",
            "rue" => "required",
            "code_postal" => "required|max:5",
            "ville" => "required",
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
            $this->redirect("/clients/update/{$id}");
            return;
        }

        $validated = $validator->validated;

        $client->fill($validated);
        $client->save();

        Session::setFlash("success", "Le client a bien été modifié.");

        // Redirection vers la création de commande car le client
        // est créé dans le flux de création de commande
        $this->redirect("/commandes/create");
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
        $client = (new Client())->find($id);

        if ($client === null) {
            Session::setFlash("danger", "Commande introuvable.");
            $this->redirect("/commandes/create");
            return;
        }

        View::render("clients.show",[
            "client"=>$client,
        ]);

    }


    /**
     * Soft delete de client
     * @param mixed $id
     * @return void
     */
    public function delete (mixed $id) : void {

        $id = intval($id);
        $client = (new Client())->find($id);

        if ($client === null) {
            Session::setFlash("danger", "Client introuvable.");
            $this->redirect("/clients");
            return;
        }

        $client->deleted_at = date('Y-m-d H:i:s');
        $client->save();

        Session::setFlash("danger", "Le client a bien été supprimé.");
        $this->redirect("/clients");

    }


}