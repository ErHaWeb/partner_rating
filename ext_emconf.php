<?php

/**
 * This file is part of the "partner_rating" Extension for TYPO3 CMS.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Partner Rating',
    'description' => 'Extbase/Fluid extension that allows departments to rate collaboration partners via a front-end form. Rating values can be specified as a comma separated list of integer values. Rating values greater than a configurable limit value must be justified. This is possible either by predefined reasons or a free text input.',
    'category' => 'plugin',
    'author' => 'Eric Harrer, Axel Hempelt',
    'author_email' => 'info@eric-harrer.de, info@fiz-soft.de',
    'author_company' => 'eric-harrer.de, fiz-soft.de',
    'state' => 'stable',
    'version' => '3.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'php' => '8.1.0-8.3.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'ErHaWeb\\PartnerRating\\' => 'Classes',
        ],
    ],
];
