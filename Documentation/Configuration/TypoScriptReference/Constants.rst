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