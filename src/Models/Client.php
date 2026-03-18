<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Traits\HasRelationships;

/**
 * Représente un client de la pizzeria.
 *
 * @package App\Core\Model
 */
class Client extends Model
{
    use HasRelationships;

    /**
     * Clé primaire
     * @var ?int
     */
    public ?int $id;

    /**
     * Nom du client
     * @var string
     */
    public string $pseudo = "";

    /**
     * @var string
     */
    public string $telephone = "";

    /**
     * @var string
     */
    public string $rue = "";

    /**
     * @var string
     */
    public string $code_postal = "";

    /**
     * @var string
     */
    public string $ville = "";




    /**
     * Liste des champs utilisés par le trait IsFillable
     * pour la génération et la préparation des requêtes SQL.
     *
     * @var string[]
     */
    public array $fillable = [
        "pseudo",
        "telephone",
        "rue",
        "code_postal",
        "ville",
    ];

    /**
     * Commandes associées à ce client.
     *
     * @return Commande[]
     */
    public function commandes(): array
    {
        return $this->hasMany(Commande::class, "client_id");
    }
}