<?php

declare(strict_types=1);

/*
 * This file is part of the "news" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace ErHaWeb\PartnerRating\Event\Listener;

use TYPO3\CMS\Core\Configuration\Event\SiteConfigurationLoadedEvent;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Event to modify the site configuration array before loading the configuration
 */
final class SiteConfigurationLoadedEventListener
{
    public function __invoke(SiteConfigurationLoadedEvent $event): void
    {
        $configuration = $event->getConfiguration();
        if (array_key_exists('PartnerRating', $configuration['routeEnhancers'] ?? [])) {
            return;
        }

        ArrayUtility::mergeRecursiveWithOverrule(
            $configuration,
            [
                'routeEnhancers' => [
                    'PartnerRating' => [
                        'type' => 'Extbase',
                        'extension' => 'PartnerRating',
                        'plugin' => 'Pi1',
                        'routes' => [
                            [
                                'routePath' => '/',
                                '_controller' => 'Rating::list',
                            ],
                            [
                                'routePath' => '/{department}',
                                '_controller' => 'Rating::show',
                                '_arguments' => [
                                    'department' => 'department',
                                ],
                            ],
                        ],
                        'defaultController' => 'Rating::list',
                        'aspects' => [
                            'department' => [
                                'type' => 'PersistedAliasMapper',
                                'tableName' => 'tx_partnerrating_domain_model_department',
                                'routeFieldName' => 'slug',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $event->setConfiguration($configuration);
    }
}
