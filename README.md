# Silverstripe sections
This module splits pages into reusable sections that can used across multiple pages.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require coreiho/silverstripe-sections 1.*
```

### Customisation
#### Styles
For each section type, you can define additional styles in your config.yml.
``` yml
LinkSection:
  styles:
    - Layout1
    - Layout2
```
This will provide optional classes for each section type to choose from in the CMS.

#### Templating
Below is the template hierarchy.
* SectionType_PageType_Style.ss e.g. LinkSection_HomePage_Tiles.ss
* SectionType_Style.ss  e.g. LinkSection_Tiles.ss
* SectionType_PageType.ss e.g. BannerSection_HomePage.ss
* SectionType.ss e.g. GallerySection.ss

#### Limit or exclude sections
You can limit or completely exclude sections from a page type by defining it in your config.yml
``` yml
HomePage:
  LimitSectionTypes:
    BannerSection: 0
    LinkSection: 0
    PeopleSection: 1
```

Limiting the total sections a page in your config.yml
``` yml
HomePage:
  LimitSectionTotal: 3
```
