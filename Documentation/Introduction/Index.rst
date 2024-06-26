..  include:: /Includes.rst.txt

..  _introduction:

============
Introduction
============

..  _what-it-does:

What does it do?
================

This Extbase/Fluid based TYPO3 extension allows departments in a company to easily rate cooperation partners via a frontend form. Rating values can be specified as a comma separated list of integer values. Rating values greater than a configurable limit value must be justified. This justification can be done either by predefined reasons or by a free text entry.

Special attention is paid to the fact that a large number of cooperation partners can be found quickly. This is possible through an AJAX-driven database search, which results in a dynamic adjustment of the partner selection field.

What does it NOT do?
====================
Currently there is no frontend access protection provided. The rating form is intended for internal use and should not be published unprotected. Therefore we recommend to use it either in the intranet, in a protected login area realized with TYPO3 on-board means or a password protection (for example via .htaccess file).

Furthermore, there is currently no possibility to statistically evaluate or display the collected rating data that is saved via the form. We therefore advise you to export the rating data as CSV with the TYPO3 on-board tools and to evaluate it with an external tool.

..  _screenshots:

Screenshots
===========

Here you can find screenshots of all application areas of this extension.

..  _screenshots-frontendview:

Frontend View
-------------

Below you can find an example of the frontend output of the partner rating
plugin. Styling and structure can be customized as you like. The default
template and styles are based on Bootstrap 5.

..  figure:: /Images/en/FrontendView.png
    :class: with-shadow
    :alt: Frontend View
    :width: 476px

    Frontend View

..  _screenshots-newcontentelementwizard:

New Content Element Wizard
--------------------------

..  figure:: /Images/en/NewContentElementWizard.png
    :class: with-shadow
    :alt: New Content Element Wizard
    :width: 999px

    New Content Element Wizard

..  _screenshots-pluginsettings:

Plugin Settings
---------------

Below you can find a screenshot of the plugin settings.

..  figure:: /Images/en/PluginSettings.png
    :class: with-shadow
    :alt: The plugin settings
    :width: 622px

    The plugin settings

..  _screenshots-records:

Records
-------

Below are screenshots of the various data sets used by the extension.

..  _screenshots-records-department:

Department
~~~~~~~~~~

..  figure:: /Images/en/ModelDepartment.png
    :class: with-shadow
    :alt: Department
    :width: 716px

    Department

..  _screenshots-records-partner:

Partner
~~~~~~~

..  figure:: /Images/en/ModelPartner.png
    :class: with-shadow
    :alt: Department
    :width: 716px

    Partner

..  _screenshots-records-reason:

Reason
~~~~~~

..  figure:: /Images/en/ModelReason.png
    :class: with-shadow
    :alt: Department
    :width: 716px

    Reason

..  _screenshots-records-rating:

Rating
~~~~~~

..  figure:: /Images/en/ModelRating.png
    :class: with-shadow
    :alt: Department
    :width: 716px

    Rating

Constant Editor
---------------

Below you can find a screenshot of all available constants in the constant editor.

..  figure:: /Images/en/ConstantEditor-Options.png
    :class: with-shadow
    :alt: Constant Editor Partner Rating Options
    :width: 734px

    Constant Editor Partner Rating Options
