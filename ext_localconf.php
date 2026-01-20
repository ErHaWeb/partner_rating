<?php

use ErHaWeb\PartnerRating\Controller\RatingController;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask;

defined('TYPO3') || die();

ExtensionUtility::configurePlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
    'PartnerRating',
    // arbitrary, but unique plugin name (not visible in the backend)
    'Pi1',
    // all actions
    [RatingController::class => 'list,show'],
    // non-cacheable actions
    [RatingController::class => 'list,show'],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'][] = 'EXT:partner_rating/Resources/Private/Templates/Email/';

if ((new Typo3Version())->getMajorVersion() < 14) {
    // TODO: Remove once TYPO3 13 support is dropped
    // TYPO3 14 configuration can be found in Configuration/TCA/Overrides/tx_scheduler_garbage_collection.php
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][TableGarbageCollectionTask::class]['options']['tables']['tx_partnerrating_domain_model_rating'] = [
        'dateField' => 'tstamp',
        'expirePeriod' => '180',
    ];
}
