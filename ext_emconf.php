<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Partner-Rating',
    'description' => 'Extbase/Fluid extension that allows departments to rate collaboration partners via a front-end form. The rating is based on school grades. Grades greater than 4 must be justified. This is possible either by predefined reasons or a free text input.',
    'category' => 'plugin',
    'author' => '',
    'author_email' => '',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
