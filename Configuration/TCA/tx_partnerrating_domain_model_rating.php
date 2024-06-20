<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating',
        'label' => 'rate_value',
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
        'searchFields' => 'rate_value, reason_text',
        'iconfile' => 'EXT:partner_rating/Resources/Public/Icons/tx_partnerrating_domain_model_rating.svg'
    ],
    'types' => [
        '1' => ['showitem' => 'rate_value, partner, reason, reason_text, department, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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
                'foreign_table' => 'tx_partnerrating_domain_model_rating',
                'foreign_table_where' => 'AND {#tx_partnerrating_domain_model_rating}.{#pid}=###CURRENT_PID### AND {#tx_partnerrating_domain_model_rating}.{#sys_language_uid} IN (-1,0)',
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
        'rate_value' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.rate_value',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.rate_value.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                    ['label' => 1, 'value' => 1],
                    ['label' => 2, 'value' => 2],
                    ['label' => 3, 'value' => 3],
                    ['label' => 4, 'value' => 4],
                    ['label' => 5, 'value' => 5],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'partner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.partner',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.partner.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_partnerrating_domain_model_partner',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'reason' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.reason',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.reason.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_partnerrating_domain_model_reason',
                'default' => 0,
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
        ],
        'reason_text' => [
            'exclude' => true,
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.reason_text',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.reason_text.description',
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
            'label' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.department',
            'description' => 'LLL:EXT:partner_rating/Resources/Private/Language/locallang_db.xlf:tx_partnerrating_domain_model_rating.department.description',
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
