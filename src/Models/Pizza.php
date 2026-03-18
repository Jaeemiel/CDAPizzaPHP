<?php
 namespace App\Models;

 use App\Core\Model;
 use App\Core\Traits\HasRelationships;

 /**
  * Représente un utilisateur de l'application.
  *
  * @package App\Core\Model
  */
 class Pizza extends Model {
     use HasRelationships;

     /**
      * Clé primaire
      * @var ?int
      */
     public ?int $id;

     /**
      * Titre de la tâche
      * @var string
      */
     public string $libelle = "";

     /**
      * Description de la tâche
      * @var string
      */
     public string $ingredients = "";

     /**
      * Date de création de la tâche
      * @var string
      */
     public string $prix = "";

     /**
      * Date de fin prévu pour la tâche
      * @var bool
      */
     public bool $en_stock = true;

     /**
      * Liste des champs utilisés par le trait IsFillable
      * pour la génération et la préparation des requêtes SQL.
      *
      * @var string[]
      */
     public array $fillable = [
         "libelle",
         "ingredients",
         "prix",
         "en_stock",
     ];



     /**
      * Commandes associées à cet pizza.
      *
      * @return Commande[]
      */
     public function commandes(){
         return $this->belongsToMany(Commande::class, "commande_pizza");
     }
 }