.. include:: /Includes.rst.txt

.. _routing:

Routing
=======

Routing can be used to rewrite URLs. In this section you will learn how to rewrite the partner rating URLs using
**Routing Enhancers and Aspects**. TYPO3 Explained has a chapter :ref:`Introduction to routing <t3coreapi:routing-introduction>`
that you can read if you are not familiar with the concept yet. You will no longer need third party extensions like
RealURL or CoolUri to rewrite and beautify your URLs.

.. _how_to_rewrite_urls:

How to rewrite URLs with partner rating parameters
--------------------------------------------------

On setting up your page you should already have created a **site configuration**.
You can do this in the backend module :guilabel:`Site Managements > Sites`.

Your site configuration will be stored in
:file:`/config/sites/<your_identifier>/config.yaml`. The following
configurations have to be applied to this file.

Any URL parameters can be rewritten with the Routing Enhancers and Aspects.
These are added manually in the :file:`config.yaml`:

Add the following YAML configuration under :yaml:`routeEnhancers`:

..  code-block:: yaml
    :linenos:
    :caption: :file:`/config/sites/<your_identifier>/config.yaml`

    routeEnhancers:
      PartnerRating:
        type: Extbase
        limitToPages:
          - 1
        extension: PartnerRating
        plugin: Pi1
        routes:
          -
            routePath: /
            _controller: 'Rating::list'
          -
            routePath: '/{department}'
            _controller: 'Rating::show'
            _arguments:
              department: department
        defaultController: 'Rating::list'
        aspects:
          department:
            type: PersistedAliasMapper
            tableName: tx_partnerrating_domain_model_department
            routeFieldName: slug