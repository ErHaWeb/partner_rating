<?php

use ErHaWeb\PartnerRating\Controller\RatingController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

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
