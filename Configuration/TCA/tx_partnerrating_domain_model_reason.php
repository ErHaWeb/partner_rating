<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,description',
        'iconfile' => 'EXT:partner_rating/Resources/Public/Icons/tx_partnerrating_domain_model_reason.svg'
    ],
    'types' => [
        '1' => ['showitem' => 'title, description, department, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_partnerrating_domain_model_reason',
                'foreign_table_where' => 'AND {#tx_partnerrating_domain_model_reason}.{#pid}=###CURRENT_PID### AND {#tx_partnerrating_domain_model_reason}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason.title',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason.title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason.description',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason.description.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'department' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason.department',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_reason.department.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_partnerrating_domain_model_department',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    ],
];
