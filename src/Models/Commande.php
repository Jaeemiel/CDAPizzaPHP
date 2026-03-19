<?php

namespace App\Models;
use App\Core\Model;
use App\Core\Traits\HasRelationships;


/**
 * Représente une Commande.
 *
 * @package App\Core\Model
 */
class Commande extends Model{
    use HasRelationships;

    /**
     * Clé primaire
     * @var ?int
     */
    public ?int $id;

    /**
     * Date avec l'heure de la commande
     * @var string
     */
    public string $date_heure = "";

    /**
     * Etat de la commande
     * @var string
     */
    public string $etat = "";

    /**
     * Montant de la commande
     * @var float
     */
    public float $montant = 0;

    /**
     * Commentaire de la commande
     * @var string
     */
    public ?string $commentaire = '';

    /**
     * Clé étrangère de client
     * @var int|null
     */
    public ?int $client_id = null;

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
        "client_id",
    ];

    /**
     * Pizzas associés à cette commande.
     *
     * @return Pizza[]
     */
    public function pizzas(){
        return $this->belongsToMany(Pizza::class, "commande_pizza");
    }

    /**
     * Client associé à la commande.
     *
     * @return Client|Client[]
     */

    public function client(){
        return $this->belongsTo(Client::class, "client_id");
    }

    public function getNameClient(){
        $client = $this->client();

        $nom = $client->pseudo;

        return $nom;
    }

    public function getQuantityPizza(){
        $targetTable =  "pizza";
        $pivotTable = "commande_pizza";
        $foreignKey = "commande_id";
        $targetKey = $targetTable . "_id";
        $sql = "SELECT {$targetTable}.libelle, {$pivotTable}.* FROM {$targetTable} JOIN {$pivotTable} 
            ON {$targetTable}.id = {$pivotTable}.{$targetKey} WHERE {$pivotTable}.{$foreignKey} = :id";
        return $this->readQuery($sql, ["id" => $this->id], false, Commande_Pizza::class);
    }

}

