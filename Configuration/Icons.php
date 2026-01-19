<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgSpriteIconProvider;

return [
    'tx-partnerrating' => [
        'provider' => SvgSpriteIconProvider::class,
        'source' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg',
        'sprite' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg#tx-partnerrating',
    ],
    'tx-partnerrating-department' => [
        'provider' => SvgSpriteIconProvider::class,
        'source' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg',
        'sprite' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg#tx-partnerrating-department',
    ],
    'tx-partnerrating-partner' => [
        'provider' => SvgSpriteIconProvider::class,
        'source' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg',
        'sprite' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg#tx-partnerrating-partner',
    ],
    'tx-partnerrating-rating' => [
        'provider' => SvgSpriteIconProvider::class,
        'source' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg',
        'sprite' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg#tx-partnerrating-rating',
    ],
    'tx-partnerrating-reason' => [
        'provider' => SvgSpriteIconProvider::class,
        'source' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg',
        'sprite' => 'EXT:partner_rating/Resources/Public/Icons/Sprite.svg#tx-partnerrating-reason',
    ],
];
