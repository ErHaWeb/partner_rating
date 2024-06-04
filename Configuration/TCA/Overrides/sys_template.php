<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

(static function (): void {
    /**
     * Extension key
     */
    $extKey = 'partner_rating';

    /**
     * TypoScript path
     */
    $path = 'Configuration/TypoScript';

    /**
     * Locallang file path
     */
    $locallangFilePath = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf';

    /**
     * Static TypoScript include title
     */
    $title = $locallangFilePath . ':sys_template.TypoScript.' . $extKey . '_title';

    /**
     * Add static TypoScript (constants and setup) directly through TCA instead of the API function to be able to translate the title
     */
    if (is_array($GLOBALS['TCA']['sys_template']['columns'])) {
        $value = str_replace(',', '', 'EXT:' . $extKey . '/' . $path);
        $GLOBALS['TCA']['sys_template']['columns']['include_static_file']['config']['items'][] = [$title, $value];
    }
})();
