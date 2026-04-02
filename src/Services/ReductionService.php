<?php

namespace App\Services;

use App\Enum\TypeReduction;
use App\Models\Client;
use App\Models\Commande;
use Exception;

class ReductionService {
    /** Taux de remise sur quantité de pizzas (5%) */
    private const REMISE_PIZZA = 0.05;

    /** Nombre minimum de pizzas pour bénéficier de la remise quantité */
    private const SEUIL_PIZZA = 5;

    /** Taux de remise de fidélité (10%) */
    private const REMISE_FIDELITE = 0.1;

    /** Nombre de commandes multiple pour bénéficier de la remise fidélité */
    private const SEUIL_FIDELITE = 3;

    /**
     * Vérifie si la commande est éligible à la réduction quantité de pizzas.
     * La réduction s'applique si le nombre total de pizzas dépasse le seuil.
     *
     * @param Commande $commande
     * @return bool
     */
    private function eligibleReductionPizza(Commande $commande):bool{
        $nbPizzas = 0;
        foreach ($commande->getCommandePizza() as $pizza){
            $nbPizzas += $pizza->nb_pizza;
        }
        return $nbPizzas > self::SEUIL_PIZZA;
    }

    /**
     * Vérifie si le client est éligible à la réduction de fidélité.
     * La réduction s'applique tous les SEUIL_FIDELITE commandes.
     *
     * @param Client $client
     * @return bool
     */
    private function eligibleReductionFidelite(Client $client):bool{
        $nbCommmandes = count($client->commandes());
        if($nbCommmandes === 0) {
            return false;
        }
        return $nbCommmandes % self::SEUIL_FIDELITE === 0;
    }

    /**
     * Retourne la liste des réductions applicables sans les appliquer.
     * Utilisé pour l'affichage des badges dans les vues.
     *
     * @param Commande $commande
     * @param Client $client
     * @return TypeReduction[]
     */
    public function getReductions (Commande $commande, Client $client) : array{
        $reductions = [];

        if($this->eligibleReductionFidelite($client)){
            $reductions[] = TypeReduction::FIDELITE;
        }

        if($this->eligibleReductionPizza($commande)){
            $reductions[] = TypeReduction::PIZZA;
        }

        return $reductions;
    }

    /**
     * Applique les réductions au montant de la commande et sauvegarde.
     * Retourne la liste des réductions appliquées.
     *
     * @param Commande $commande
     * @param Client $client
     * @return TypeReduction[]
     * @throws Exception
     */
    public function appliqueReductions (Commande $commande, Client $client) : array{
        $montant = $commande->montant_initial;
        $reductions = $this->getReductions($commande,$client);

        foreach ($reductions as $reduction){
            $montant = $montant * (1 - $reduction->remise());
        }

        $commande->montant_final = round($montant,2);
        $commande->save();

        return $reductions;
    }

}