<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

(static function (): void {
    ExtensionUtility::registerPlugin(
    // extension name, matching the PHP namespaces (but without the vendor)
        'PartnerRating',
        // arbitrary, but unique plugin name (not visible in the backend)
        'Pi1',
        // plugin title, as visible in the drop-down in the backend, use "LLL:" for localization
        'LLL:EXT:partner_rating/Resources/Private/Language/locallang_be.xlf:partnerrating_pi1.title'
    );
})();