<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Model;
use App\Core\Traits\IsFillable;
use App\Enum\Role;

/**
 * Représente un employé de la pizzeria.
 *
 * @package App\Core\Model
 */
class Utilisateur extends Model{
    use IsFillable;

    /**
     * Clé primaire
     * @var int|null
     */
    public ?int $id = null;

    /**
     * Nom d'utilisateur pour se connecter
     * @var string
     */
    public string $login = "";

    /**
     * Hash bcrypt du mot de passe — jamais stocké en clair.
     * @var string
     */
    public string $password = "";

    /**
     * Représente si un mot de passe doit changer ou non.
     * 1 oui, 0 non
     * @var int
     */
    public int $must_change_password = 1;

    /** Date de dernière modification
     * @var string|null
     */
    public ?string $password_changed_at  = null;

    /**
     * Rôle de l'utilisateur
     * @see Role
     * @var string
     */
    public string $role = "";

    /**
     * Représente si l'employé est actif ou non (ex: false si congé)
     * @var bool
     */
    public bool $actif = true;

    /** Date de création
     * @var string|null
     */
    public ?string $created_at = null;

    /** Date de dernière modification
     * @var string|null
     */
    public ?string $updated_at = null;

    /** Date de suppression logique (soft delete)
     * @var string|null
     */
    public ?string $deleted_at = null;

    public array $fillable = [
        "login",
        "password",
        "role",
        "actif",
        "must_change_password",
    ];

    /**
     * Initialise la connexion vers la base CDAPersonnel
     * et définit le nom de table depuis le nom de classe.
     */
    public function __construct(){
        $this->pdo = Database::getPDO('personnel');
        $this->table = get_class($this);
    }



}