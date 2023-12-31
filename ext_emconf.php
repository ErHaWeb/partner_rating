<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Partner Rating',
    'description' => 'Extbase/Fluid extension that allows departments to rate collaboration partners via a front-end form. Rating values can be specified as a comma separated list of integer values. Rating values greater than a configurable limit value must be justified. This is possible either by predefined reasons or a free text input.',
    'category' => 'plugin',
    'author' => 'Eric Harrer, Axel Hempelt',
    'author_email' => 'info@eric-harrer.de, info@fiz-soft.de',
    'author_company' => 'eric-harrer.de, fiz-soft.de',
    'state' => 'stable',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
            'php' => '7.4.0-8.2.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'ErHaWeb\\PartnerRating\\' => 'Classes',
        ],
    ],
];