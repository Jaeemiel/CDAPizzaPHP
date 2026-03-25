<?php

namespace App\Models;

use App\Core\Model;


/**
 * Représente la table pivot entre Commande et Pizza.
 *
 * @package App\Core\Model
 */
class Commande_Pizza extends Model
{
    /**
     * Clé primaire composite avec pizza_id.
     * @var ?int
     */
    public ?int $commande_id = null;

    /**
     * Clé primaire composite avec commande_id.
     * @var ?int
     */
    public ?int $pizza_id = null;

    /**
     * Nombre de la pizza
     * @var ?int
     */
    public ?int $nb_pizza = null;

    /**
     * Nom de la pizza — propriété hydratée dynamiquement via JOIN,
     * n'existe pas dans la table commande_pizza.
     * @var string
     */
    public string $libelle = "";

    /**
     * Prix unitaire de la pizza
     * @var float
     */
    public float $prix_unitaire = 0;
}