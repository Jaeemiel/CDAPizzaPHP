<?php

namespace App\Enum;

enum Role: string
{
    case GUICHET = 'GUICHET';
    case CUISINE = 'CUISINE';
    case GERANT = 'GERANT';
}