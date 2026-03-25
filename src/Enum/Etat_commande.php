<?php
namespace App\Enum;

enum Etat_commande: string
{
    case PAYER = 'PAYER';
    case PREPARATION = 'PREPARATION';
    case PRETE = 'PRETE';
    case LIVRER = 'LIVRER';

    public function badge(): string
    {
        return match($this) {
            self::PAYER       => 'badge bg-secondary',
            self::PREPARATION => 'badge bg-warning text-dark',
            self::PRETE       => 'badge bg-info text-dark',
            self::LIVRER      => 'badge bg-success',
        };
    }

    public function label(): string
    {
        return match($this) {
            self::PAYER       => 'À payer',
            self::PREPARATION => 'En préparation',
            self::PRETE       => 'Prête',
            self::LIVRER      => 'Livrée',
        };
    }

    public function suivant(): ?self {
        $cases = self::cases();
        $index = array_search($this,$cases);

        //Retourne null si dernier état
        return $cases[$index+1] ?? null;
    }

}