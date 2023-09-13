<?php

declare(strict_types=1);

/**
 * This file is part of the "Partner-Rating" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023
 */

use ErHaWeb\PartnerRating\Middleware\GetPartner;

return [
    'frontend' => [
        'erhaweb/partner-rating/get-partner' => [
            'target' => GetPartner::class,
            'after' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
        ],
    ],
];
