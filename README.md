# Partner Rating
This Extbase/Fluid based TYPO3 extension allows to easily rate cooperation partners via a frontend form. The rating is given by a department, which can be selected before. Each department can give a cooperation partner a school grade from 1 to 5. For grades worse than 3, a justification for the evaluation must be given. The justification can be either a freely selectable text or a predefined text.

## Route Enhancer Configuration

Add the following YAML configuration to your site configuration to ensure that the extension uses nice URL paths based on the `slug` field.

```yaml
routeEnhancers:
  PartnerRating:
    type: Extbase
    limitToPages: [1]
    extension: PartnerRating
    plugin: Pi1
    routes:
      - routePath: '/'
        _controller: 'Rating::list'
      - routePath: '/{department_title}'
        _controller: 'Rating::show'
        _arguments:
          department_title: 'department'
      - routePath: '/{department_title}/saved/{saved_rating}'
        _controller: 'Rating::show'
        _arguments:
          department_title: 'department'
          saved_rating: 'savedRating'
      - routePath: '/{department_title}/send'
        _controller: 'Rating::save'
        _arguments:
          department_title: 'department'
    defaultController: 'Rating::show'
    aspects:
      department_title:
        type: PersistedAliasMapper
        tableName: tx_partnerrating_domain_model_department
        routeFieldName: slug
      saved_rating:
        type: PersistedAliasMapper
        tableName: tx_partnerrating_domain_model_rating
        routeFieldName: uid
```

**Hint**

The URL path /saved/<ID> is set by the RouteEnhancer, but does not appear in the browser because this path section is removed from the URL in the browser's address bar immediately after the page is reloaded using the History API. This way, the nice section URLs are preserved without additional sections.