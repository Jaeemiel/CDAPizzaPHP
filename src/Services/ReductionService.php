<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Commande;

class ReductionService {
    private const REMISE_PIZZA = 0.05;
    private const SEUIL_PIZZA = 5;
    private const REMISE_FIDELITE = 0.1;
    private const SEUIL_FIDELITE = 3;

    private function eligibleReductionPizza(Commande $commande):bool{
        $nbPizzas = 0;
        foreach ($commande->getQuantityPizza() as $pizza){
            $nbPizzas += $pizza->nb_pizza;
        }
        return $nbPizzas > self::SEUIL_PIZZA;
    }

    private function eligibleReductionFidelite(Client $client):bool{
        $nbCommmandes = count($client->commandes());
        if($nbCommmandes === 0) {
            return false;
        }
        return $nbCommmandes % self::SEUIL_FIDELITE === 0;
    }
    public function appliqueReductions (Commande $commande, Client $client) : array{
        $montant = $commande->montant;
        $reductions = [];

        if($this->eligibleReductionFidelite($commande)){
            $montant = $montant * (1 - self::REMISE_FIDELITE);
            $reductions[] = "10% de fidélité";
        }

        if($this->eligibleReductionPizza($commande)){
            $montant = $montant * (1 - self::REMISE_PIZZA);
            $reductions[] = "5% sur quantité de pizzas";
        }

        $commande->montant = round($montant,2);
        $commande->save();

        return $reductions;
    }    

}