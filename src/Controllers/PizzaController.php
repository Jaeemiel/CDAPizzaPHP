<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Core\View;
use App\Models\Pizza;
use Exception;

class PizzaController extends Controller
{
    /**
     * Liste toutes les pizzas
     * @return void
     * @throws Exception
     */
    public function index() : void{
        View::render("pizzas.index",[
            "pizzas"=>(new Pizza())->findAll(),
        ]);
    }

    /**
     * Page du formulaire de création : GET
     * @return void
     * @throws Exception
     */
    public function create() : void{
        View::render("pizzas.form",[
            "pizza"=>(new Pizza()),
        ]);
    }

    /**
     * Page du formulaire de création : POST
     * @return void
     * @throws Exception
     */
    public function store() : void {
        $validator = new Validator($_POST,[
            "libelle" => "required",
            "ingredients"=>"required",
            "prix"=>"required",
            "en_stock"=>"required",
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
            $this->redirect("/pizzas/create");
            return;
        }

        $validate = $validator->validated;

        $pizza = new Pizza();
        $pizza->fill($validate);

        $pizza->save();

        Session::setFlash("success", "La pizza a bien été créé.");
        $this->redirect("/pizzas");
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
        $pizza = (new Pizza())->find($id);

        if ($pizza === null) {
            Session::setFlash("danger", "Pizza introuvable.");
            $this->redirect("/pizzas");
            return;
        }

        View::render("pizzas.form",[
            "pizza"=>$pizza,
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
        $pizza = (new Pizza())->find($id);

        if ($pizza === null) {
            Session::setFlash("danger", "Pizza introuvable.");
            $this->redirect("/pizzas");
            return;
        }

        $validator = new Validator($_POST,[
            "libelle" => "required",
            "ingredients"=>"required",
            "prix"=>"required",
            "en_stock"=>"required",
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
            $this->redirect("/pizzas/update/{$id}");
            return;
        }

        $validate = $validator->validated;

        $pizza->fill($validate);

        $pizza->save();

        Session::setFlash("success", "La pizza a bien été modifié.");
        $this->redirect("/pizzas");
    }


    /**
     * Page de la pizza
     *
     * @param mixed $id
     * @return void
     * @throws Exception
     */
    public function show(mixed $id) : void {
        $id = intval($id);
        $pizza = (new Pizza())->find($id);

        if ($pizza === null) {
            Session::setFlash("danger", "Pizza introuvable.");
            $this->redirect("/pizzas");
            return;
        }

        View::render("pizzas.show",[
            "pizza"=>$pizza,
        ]);

    }

    /**
     * Soft delete de pizza
     * @param mixed $id
     * @return void
     */
    public function delete (mixed $id) : void {
        $id = intval($id);
        $pizza = (new Pizza())->find($id);

        if ($pizza === null) {
            Session::setFlash("danger", "Pizza introuvable.");
            $this->redirect("/pizzas");
            return;
        }

        $pizza->deleted_at = date('Y-m-d H:i:s');
        $pizza->save();

        Session::setFlash("danger", "La pizza a bien été supprimé.");
        $this->redirect("/pizzas");
    }
}