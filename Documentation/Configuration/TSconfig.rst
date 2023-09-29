..  include:: /Includes.rst.txt
..  highlight:: typoscript
..  index::
    TSconfig
..  _configuration-tsconfig:

Page TSconfig
=============

After the extension has been installed, it automatically adds Page TSconfig
from file `EXT:partner_rating/Configuration/page.tsconfig` to register the
"Partner Rating" plug-in content element in the New Content Element Wizard.

The following code will be added:

..  code-block:: typoscript

    mod.wizards.newContentElement.wizardItems {
        plugins {
            elements {
                partnerrating_pi1 {
                    iconIdentifier = partnerrating_pi1
                    title = LLL:EXT:partner_rating/Resources/Private/Language/locallang_be.xlf:partnerrating_pi1.title
                    description = LLL:EXT:partner_rating/Resources/Private/Language/locallang_be.xlf:partnerrating_pi1.description
                    tt_content_defValues {
                        CType = list
                        list_type = partnerrating_pi1
                    }
                }
            }

            show := addToList(partnerrating_pi1)
        }
    }