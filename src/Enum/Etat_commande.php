<?php
namespace App\Enum;

enum Etat_commande: string
{
    case PAYER = 'PAYER';
    case CUISINE = 'CUISINE';
}