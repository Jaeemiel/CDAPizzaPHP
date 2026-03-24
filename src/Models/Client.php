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
    public ?int $id = null;

    /**
     * Nom du client
     * @var string
     */
    public string $nom = "";

    /**
     * Prénom du client
     * @var string
     */
    public string $prenom = "";

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

    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;



    /**
     * Liste des champs utilisés par le trait IsFillable
     * pour la génération et la préparation des requêtes SQL.
     *
     * @var string[]
     */
    public array $fillable = [
        "nom",
        "prenom",
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