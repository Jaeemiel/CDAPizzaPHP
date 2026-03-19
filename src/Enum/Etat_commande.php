<?php
namespace App\Enum;

enum Etat_commande: string
{
    case PAYER = 'PAYER';
    case PREPARATION = 'PREPARATION';
    case PRETE = 'PRETE';
    case LIVRER = 'LIVRER';
}