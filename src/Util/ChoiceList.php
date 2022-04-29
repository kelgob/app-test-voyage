<?php

declare(strict_types=1);

namespace App\Util;

use App\Entity\Etape;

final class ChoiceList
{
    public static function getEtapeTypes(): array
    {
        return [
            Etape::TYPE_BUS,
            Etape::TYPE_CAR,
            Etape::TYPE_PLANE,
            Etape::TYPE_TRAIN,
        ];
    }
}