..  include:: /Includes.rst.txt
..  highlight:: typoscript

..  index::
    TypoScript; Constants
..  _configuration-typoscript-constants:

Constants
=========

..  _configuration-typoscript-constants-view:

View
----

The following options are located under the following path:
:typoscript:`plugin.tx_partnerrating_pi1.view`

..  _configuration-typoscript-constants-view-templaterootpath:

Template root path
~~~~~~~~~~~~~~~~~~

..  confval:: templateRootPath

    :type: string
    :Default: empty
    :Path: plugin.tx_partnerrating_pi1.view

    In addition to the default path `EXT:partner_rating/Resources/Private/Templates/`,
    this constant can be used to define a custom template root path to overwrite
    individual fluid files as needed.

..  _configuration-typoscript-constants-view-partialrootpath:

Partial root path
~~~~~~~~~~~~~~~~~

..  confval:: partialRootPath

    :type: string
    :Default: empty
    :Path: plugin.tx_partnerrating_pi1.view

    In addition to the default path `EXT:partner_rating/Resources/Private/Partials/`,
    this constant can be used to define a custom partial root path to overwrite
    individual fluid files as needed.

..  _configuration-typoscript-constants-view-layoutrootpath:

Layout root path
~~~~~~~~~~~~~~~~~

..  confval:: layoutRootPath

    :type: string
    :Default: empty
    :Path: plugin.tx_partnerrating_pi1.view

    In addition to the default path `EXT:partner_rating/Resources/Private/Layouts/`,
    this constant can be used to define a custom layout root path to overwrite
    individual fluid files as needed.

..  _configuration-typoscript-constants-settings:

Settings
--------

The following options are located under the following path:
:typoscript:`plugin.tx_partnerrating_pi1.settings`

..  _configuration-typoscript-constants-settings-includebootstrap:

Include Bootstrap from CDN
~~~~~~~~~~~~~~~~~~~~~~~~~~

..  confval:: includeBootstrap

    :type: boolean
    :Default: false
    :Path: plugin.tx_partnerrating_pi1.settings

    If this option is `true` then Bootstrap 5 will be included via CDN from jsDelivr. This option should only be used for testing purposes. If you want to use Bootstrap 5 (the default framework of the Partner Rating template) for rendering, it is recommended to include it yourself via your site package and leave this option disabled.

..  _configuration-typoscript-constants-settings-cssfile:

CSS File
~~~~~~~~

..  confval:: cssFile

    :type: string
    :Default: EXT:partner_rating/Resources/Public/Css/main.min.css
    :Path: plugin.tx_partnerrating_pi1.settings

    CSS file that is used by default

..  _configuration-typoscript-constants-settings-javascriptfile:

JavaScript File
~~~~~~~~~~~~~~~

..  confval:: javaScriptFile

    :type: string
    :Default: EXT:partner_rating/Resources/Public/JavaScript/show.min.js
    :Path: plugin.tx_partnerrating_pi1.settings

    JavaScript file that is used by default

..  _configuration-typoscript-constants-settings-ratingvalues:

Rating Values
~~~~~~~~~~~~~

..  confval:: ratingValues

    :type: string
    :Default: 1,2,3,4,5
    :Path: plugin.tx_partnerrating_pi1.settings

    Comma separated list of integer values that can be selected for the rating.

..  _configuration-typoscript-constants-settings-ratingreasonminvalue:

Rating Reason Min. Value
~~~~~~~~~~~~~~~~~~~~~~~~

..  confval:: ratingReasonMinValue

    :type: int
    :Default: 3
    :Path: plugin.tx_partnerrating_pi1.settings

    If the selected rating exceeds this limit, then there is an obligation to select a reason.

..  _configuration-typoscript-constants-settings-keepminonesearchresult:

Keep min. one search result
~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  confval:: keepMinOneSearchResult

    :type: boolean
    :Default: true
    :Path: plugin.tx_partnerrating_pi1.settings

    If this setting is `true`, then it is ensured that at least one result remains in the partner selection list, even if the entered string no longer leads to any results.

..  _configuration-typoscript-constants-settings-partnerlabelfields:

Partner Label Fields
~~~~~~~~~~~~~~~~~~~~

..  confval:: partnerLabelFields

    :type: string
    :Default: title,partner_nr
    :Path: plugin.tx_partnerrating_pi1.settings

    Comma-separated list of database fields to be used for forming the label of entries in the partner selection field. Fields that do not exist in the partner table are ignored.

..  _configuration-typoscript-constants-settings-partnerlabelfieldsplitstring:

Partner Label Field Split String
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  confval:: partnerLabelFieldSplitString

    :type: string
    :Default: |
    :Path: plugin.tx_partnerrating_pi1.settings

    String used between label fields that are defined by `partnerLabelFields`.

..  _configuration-typoscript-constants-settings-allowmultiplereasons:

Allow Multiple Reasons
~~~~~~~~~~~~~~~~~~~~~~

..  confval:: allowMultipleReasons

    :type: boolean
    :Default: false
    :Path: plugin.tx_partnerrating_pi1.settings

    If this setting is `true`, multiple reasons can be selected (checkboxes). If this setting is `false`, only one reason can be selected (radio buttons).