<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;
use App\Models\Client;

class ClientController extends Controller{

    public function create () : void{
        View::render("clients.form");
    }

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
                    Session::set("old", $_POST);
                    $this->redirect("/clients/create");
                    return;
                }
            }
        }

        $validate = $validator->validated;

        $client = new Client();
        $client->fill($validate);

        $client->save();

        Session::setFlash("success", "Le client a bien été créé.");
        $this->redirect("/commandes/create");

    }


    # TODO: A voir plus tard où situer cette fonctionnalité
    public function edit (mixed $id) : void {
        $id = intval($id);
        $client = (new Client())->find($id);
        View::render("clients.form",[
            "client"=>$client,
        ]);
    }

    public function update (mixed $id) : void {
        $id = intval($id);
        $client = (new Client())->find($id);

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
                    Session::set("old", $_POST);
                    $this->redirect("/clients/update/{$id}");
                    return;}
            }
        }

        $validated = $validator->validated;

        $client->fill($validated);
        $client->save();

        Session::setFlash("success", "Le client a bien été modifié.");
        $this->redirect("/commandes/create");
    }

    public function delete (mixed $id) : void {

        $id = intval($id);
        $client = (new Client())->find($id);
        $client->deleted_at = date('Y-m-d H:i:s');
        $client->save();

        Session::setFlash("success", "Le client a bien été supprimé.");
        $this->redirect("/clients");

    }


}