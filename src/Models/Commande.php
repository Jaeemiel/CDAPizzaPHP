<?php

namespace App\Models;
use App\Core\Model;
use App\Core\Traits\HasRelationships;
use App\Enum\Etat_commande;


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
    public ?int $id = null;

    /**
     * Date avec l'heure de la commande
     * @var string|null
     */
    public ?string $created_at = null;

    /**
     * Etat de la commande
     * @see Etat_commande
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
     * @var string|null
     */
    public ?string $commentaire = null;

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
        "commentaire",
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
     * @return Client
     */
    public function client(){
        return $this->belongsTo(Client::class, "client_id");
    }

    public function getNameClient(){
        $client = $this->client();

        $nom = $client->nom;
        $prenom = $client->prenom;
        return $nom . ' ' . $prenom;
    }


    /**
     * Retourne les pizzas de la commande avec leurs quantités et prix unitaires.
     * Inclut libelle, nb_pizza et prix_unitaire depuis la table pivot.
     *
     * @return Commande_Pizza[]
     */
    public function getQuantityPizza(){
        $targetTable =  "pizza";
        $pivotTable = "commande_pizza";
        $foreignKey = "commande_id";
        $targetKey = $targetTable . "_id";
        $sql = "SELECT {$targetTable}.libelle, {$pivotTable}.* FROM {$targetTable} JOIN {$pivotTable} 
            ON {$targetTable}.id = {$pivotTable}.{$targetKey} WHERE {$pivotTable}.{$foreignKey} = :id";
        return $this->readQuery($sql, ["id" => $this->id], false, Commande_Pizza::class);
    }


    /**
     * Synchronise les pizzas d'une commande avec leurs quantités et prix.
     * Supprime les anciennes entrées et réinsère les nouvelles.
     *
     * @param array $pizzas [['pizza_id' => 1, 'nb_pizza' => 2, 'prix_unitaire' => 10.5], ...]
     * @return bool
     */
    public function syncPizzas(array $pizzas): bool
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Supprime les anciennes lignes
            $stmt = $this->pdo->prepare("DELETE FROM commande_pizza WHERE commande_id = :id");
            $stmt->execute(["id" => $this->id]);

            // 2. Réinsère les nouvelles
            if (!empty($pizzas)) {
                $sql = "INSERT INTO commande_pizza (commande_id, pizza_id, nb_pizza, prix_unitaire) 
                    VALUES (:commande_id, :pizza_id, :nb_pizza, :prix_unitaire)";
                $stmt = $this->pdo->prepare($sql);

                foreach ($pizzas as $pizza) {
                    $stmt->execute([
                        "commande_id"  => $this->id,
                        "pizza_id"     => $pizza["pizza_id"],
                        "nb_pizza"     => $pizza["nb_pizza"],
                        "prix_unitaire"=> $pizza["prix_unitaire"],
                    ]);
                }
            }

            $this->pdo->commit();
            return true;

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

}

