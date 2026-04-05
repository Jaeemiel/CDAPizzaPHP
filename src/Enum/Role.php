<?php

namespace App\Enum;

enum Role: string
{
    case GUICHET = 'GUICHET';
    case CUISINE = 'CUISINE';
    case GERANT = 'GERANT';

    /**
     * Retourne les états que ce rôle peut faire avancer.
     *
     * @return EtatCommande[]
     */
    public function etatsModifiables(): array {
        return match($this) {
            self::GUICHET => [EtatCommande::PAYER, EtatCommande::PRETE],
            self::CUISINE => [EtatCommande::PREPARATION],
            default       => [],
        };
    }

    /**
     * Vérifie si ce rôle peut changer l'état donné.
     *
     * @param EtatCommande $etat
     * @return bool
     */
    public function peutChangerEtat(EtatCommande $etat): bool {
        return in_array($etat, $this->etatsModifiables());
    }

}