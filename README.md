# Silverstripe sections
This module splits pages into reusable sections that can used across multiple pages.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require coreiho/silverstripe-sections 1.*
```

### Customisation
#### Templating
For each section type, you can define additional templates in your config.yml
```
LinkSection:
  styles:
    - Layout1
    - Layout2
```
