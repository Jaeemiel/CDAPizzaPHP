<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Model;
use App\Core\Traits\IsFillable;

class Utilisateur extends Model
{
    use IsFillable;

    public ?int $id;
    public string $login = "";
    public string $password = "";
    public string $role = "";
    public bool $actif = true;

    public array $fillable = [
        "login",
        "password",
        "role",
        "actif",
    ];

    public function __construct(){
        $this->pdo = Database::getPDO('personnel');
        $this->table = get_class($this);
    }



}