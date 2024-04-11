<?php

use ErHaWeb\PartnerRating\Controller\RatingController;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
    [RatingController::class => 'list,show']
);

$versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
// Only include page.tsconfig if TYPO3 version is below 12 so that it is not imported twice.
if ($versionInformation->getMajorVersion() < 12) {
    ExtensionManagementUtility::addPageTSConfig('
      @import "EXT:partner_rating/Configuration/page.tsconfig"
   ');
}