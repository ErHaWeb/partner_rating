<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

(static function (): void {
    ExtensionManagementUtility::addStaticFile('partner_rating', 'Configuration/TypoScript', 'Partner Rating');
})();
