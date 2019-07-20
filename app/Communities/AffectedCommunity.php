<?php

declare(strict_types=1);

namespace App\Communities;

class AffectedCommunity
{
    private static $affectedCommunitiesList = [
        'vision'    => 'Vision',
        'motor'     => 'Motor',
        'hearing'   => 'Hearing',
        'cognitive' => 'Cognitive',
    ];

    public static function getAffectedCommunities() : array
    {
        return self::$affectedCommunitiesList;
    }
}