<?php

namespace App\Entity;

enum TransportType: string
{
    case Bike = 'Bike';
    case Bus = 'Bus';
    case Car = 'Car';
    case Train = 'Train';
}
