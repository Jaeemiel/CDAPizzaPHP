<?php


namespace App\Enum;

enum ValidationError: string
{
    case REQUIRED = "required";
    case UNIQUE = "unique";
    case EXISTS = "exists";
    case MIN = "min";
    case MAX = "max";
    case PASSWORD = 'password';


    /**
     * Regarde la règle et envoie le message correspondant
     *
     * @param string $field
     *
     * @return string
     */
    public function message(string $field): string
    {
        return match ($this) {
            self::REQUIRED => "Le champ {$field} est obligatoire.",
            self::UNIQUE => "La valeur du champ {$field} existe déjà.",
            self::EXISTS => "La valeur du champ {$field} n'existe pas.",
            self::MIN => "La valeur du champ: {$field} est trop courte.",
            self::MAX => "La valeur du champ: {$field} est trop longue.",
            self::PASSWORD => "Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.",
        };
    }
}