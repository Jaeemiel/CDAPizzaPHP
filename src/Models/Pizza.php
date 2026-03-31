<?php
 namespace App\Models;

 use App\Core\Model;
 use App\Core\Traits\HasRelationships;

 /**
  * Représente une pizza de la pizzeria.
  *
  * @package App\Core\Model
  */
 class Pizza extends Model {
     use HasRelationships;

     protected bool $softDeletable = true;

     /**
      * Clé primaire
      * @var ?int
      */
     public ?int $id = null;

     /**
      * Nom de la pizza
      * @var string
      */
     public string $libelle = "";

     /**
      * Ingrédients de la pizza sous forme de texte libre
      * @var string|null
      */
     public ?string $ingredients = null;

     /**
      * Prix actuel de la pizza (peut évoluer dans le temps)
      * @var float
      */
     public float $prix = 0;

     /**
      * Représente si la pizza est en stock ou non
      * 1 oui, 0 non
      * @var int
      */
     public int $en_stock = 1;


     /** Date de création @var string|null */
     public ?string $created_at = null;

     /** Date de dernière modification @var string|null */
     public ?string $updated_at = null;

     /** Date de suppression logique (soft delete) @var string|null */
     public ?string $deleted_at = null;

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

     public function findAvailable(): array {
         $sql = "SELECT * FROM {$this->getNameTable()} WHERE deleted_at IS NULL AND en_stock = 1";
         return $this->readQuery($sql);
     }
 }