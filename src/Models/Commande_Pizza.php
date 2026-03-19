<?php

namespace App\Models;

class Commande_Pizza extends \App\Core\Model
{
    /**
     * Clé primaire
     * @var ?int
     */
    public ?int $commande_id;

    /**
     * Clé primaire
     * @var ?int
     */
    public ?int $pizza_id;

    /**
     * Nombre de la pizza
     * @var ?int
     */
    public ?int $nb_pizza;

    /**
     * Prix unitaire de la pizza
     * @var string
     */
    public string $libelle;

    /**
     * Prix unitaire de la pizza
     * @var float
     */
    public float $prix_unitaire = 0;
}