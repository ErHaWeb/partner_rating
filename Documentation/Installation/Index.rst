..  include:: /Includes.rst.txt

..  _installation:

============
Installation
============

..  tabs::

    ..  group-tab:: Composer

        **Install the extension with Composer**

        #.  In your command line interface, change to the root directory of your project and enter the following command:

            ..  code-block:: bash

                composer req erhaweb/partner-rating

        #.  Apply database changes

            This extension requires a database update to add new tables that store the information about departments, partners, rating reasons and ratings.

            These tables can be created under `Admin Tools` → `Maintenance` → `Analyze Database Structure` → `Apply selected changes`.

            ..  figure:: /Images/en/Maintenance-AnalyzeDatabaseStructure.png
                :class: with-shadow
                :alt: Maintenance: Analyze Database Structure
                :width: 901px

                Maintenance: Analyze Database Structure

            ..  tip::

                If you have installed the `TYPO3 Console Extension by Helmut Hummel <https://extensions.typo3.org/extension/typo3_console>`__, you can also create the missing tables with the following command:

                ..  code-block:: bash

                    # TYPO3 11.5
                    typo3cms database:updateschema "*.add,*.change"

                    # TYPO3 >= 12.4
                    typo3 database:updateschema "*.add,*.change"


    ..  group-tab:: Composer/DDEV

        **Install the extension with Composer in a DDEV environment**

        #.  In your command line interface, change to the root directory of your project and enter the following command:

            ..  code-block:: bash

                ddev composer req erhaweb/partner-rating

        #.  Apply database changes

            This extension requires a database update to add new tables that store the information about departments, partners, rating reasons and ratings.

            These tables can be created under `Admin Tools` → `Maintenance` → `Analyze Database Structure` → `Apply selected changes`.

            ..  figure:: /Images/en/Maintenance-AnalyzeDatabaseStructure.png
                :class: with-shadow
                :alt: Maintenance: Analyze Database Structure
                :width: 901px

                Maintenance: Analyze Database Structure

            ..  tip::

                If you have installed the `TYPO3 Console Extension by Helmut Hummel <https://extensions.typo3.org/extension/typo3_console>`__, you can also create the missing tables with the following command:

                ..  code-block:: bash

                    # TYPO3 11.5
                    ddev typo3cms database:updateschema "*.add,*.change"

                    # TYPO3 >= 12.4
                    ddev typo3 database:updateschema "*.add,*.change"

    ..  group-tab:: Classic

        **Install the extension in the classic way**

        #.  Open the TYPO3 backend.

        #.  Go to the Extension Manager under `Admin Tools` → `Extensions`.

        #.  Select `Get Extensions` in the module header.

        #.  Enter the extension key `partner_rating` in the search field.

        In the result list click the `Import & Install` button under `Actions`