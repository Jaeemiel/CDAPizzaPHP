<?php

namespace App\Enum;

enum TypeReduction: string {

    case FIDELITE = 'fidélité';
    case PIZZA    = 'pizza';

    public function label(): string {
        return match($this) {
            self::FIDELITE => '10% de fidélité',
            self::PIZZA    => '5% sur quantité de pizzas',
        };
    }

    public function remise(): float {
        return match($this) {
            self::FIDELITE => 0.10,
            self::PIZZA    => 0.05,
        };
    }
}