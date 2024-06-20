.. include:: /Includes.rst.txt

.. _quickStart:

===========
Quick start
===========

..  rst-class:: bignums-tip

1.  :ref:`Install <installation>` the Extension

2.  Include the Extension configuration

    The modern recommended way to reference the configuration of this extension
    since TYPO3 v13 is via its Site Set. Alternatively, it is still possible to
    use the static include in the template record.

    ..  tabs::

        ..  group-tab:: Site Set

            #.  Go to the Sites module under `Site Management` → `Sites`

            #.  Select `Partner Rating` under `Sets for this Site`

            #.  Click `Save` and `Close`.

            ..  tip::

                You will notice that the constant editor can no longer be opened if the configuration
                was referenced via Site Set. To overwrite the default setting values of
                `EXT:partner_rating/Configuration/Sets/PartnerRating/settings.definitions.yaml`,
                use a file `config/sites/<site-identifier>/settings.yaml`.

                **Example:** Activating the integration of Bootstrap assets (for test purposes)

                ..  code-block:: yaml
                    :linenos:
                    :caption: `config/sites/<site-identifier>/settings.yaml`

                    plugin:
                      tx_partnerrating_pi1:
                        settings:
                          includeBootstrap: 1


        ..  group-tab:: Static TypoScript Include

            #.  Go to the Template module under `Web` → `Template` (TYPO3 11.5) or `Site Management` → `TypoScript` (TYPO3 >= 12.4).

            #.  Select `Info/Modify` (TYPO3 11.5) `Info/Modify` or `Edit TypoScript Record` (TYPO3 >= 12.4) in the module header.

            #.  Click the button `Edit the whole template record`.

            #.  Switch to the tab `Advanced Options`.

            #.  Select `Partner Rating: Static TypoScript Include (partner_rating)` under `Include static (from extensions)` (TYPO3 11.5) or `Include TypoScript sets` (TYPO3 >= 12.4) → `Available Items`.

            #.  Click `Save` and `Close`.

3.  Create a record storage page and records for departments, partners and reasons

    #.  Go to the Page module under `Web` → `List`.

    #.  In the Pagetree create a new page of type "Folder" and select this page

    #.  Click `Create new record` in the module header.

    #.  Select `Partner Rating` → `Department` to create new Departments. For each department add a "Title" and click `Save` and `Close`.

    #.  Select `Partner Rating` → `Partner` to create new Partners. For each partner add a "Title" and a "Partner Nr" and click `Save` and `Close`.

    #.  Select `Partner Rating` → `Rating Reason` to create new Rating reasons. For each Rating reasons add a "Title" and a "Description" and click `Save` and `Close`.

4.  Create the plugin content element

    #.  Go to the Page module under `Web` → `Page`.

    #.  In the Pagetree view click on the page where you want the partner rating form plugin content element to be displayed.

    #.  Click the `+ Content` button where you want the partner rating form plugin content element to be placed.

    #.  Switch to the tab `Plugins`.

    #.  Select the `Partner Rating` item.

    #.  In the tab `General` you may want to enter some general content information like a header.

    #.  Switch to tab `Plugin`.

    #.  Under `Record Storage Page` add the data storage page on which the partner rating data records for departments, partners and rating reasons are located (from step 3) and which will later also store the submitted ratings.

    #.  Under `Recursive` select a recursive level if the records are to be obtained from lower hierarchy levels. If in doubt, leave this value at "0". This means that all records of the extension are in the same storage page.

    #.  Click `Save` and `Close`.

5.  Done

    The partner rating form plugin content element can now be viewed in the frontend on the page where you
    created the plugin.