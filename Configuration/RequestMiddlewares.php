<?php

declare(strict_types=1);

use ErHaWeb\PartnerRating\Middleware\GetPartner;

return [
    'frontend' => [
        'erhaweb/partner-rating/get-partner' => [
            'target' => GetPartner::class,
            'after' => [
                'typo3/cms-frontend/site',
            ],
            'before' => [
                'typo3/cms-frontend/eid',
            ],
        ],
    ],
];
