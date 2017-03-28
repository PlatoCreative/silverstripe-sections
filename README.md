# Silverstripe sections
This module splits pages into reusable sections that can used across multiple pages.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require plato-creative/silverstripe-sections 1.*
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

1. SectionType_PageType_Style.ss e.g. LinkSection_HomePage_Tiles.ss
2. SectionType_Style.ss  e.g. LinkSection_Tiles.ss
3. SectionType_PageType.ss e.g. BannerSection_HomePage.ss
4. SectionType.ss e.g. GallerySection.ss

#### Section Configuration

##### Limit or exclude
You can limit or completely exclude sections from a page type by defining it in your config.yml
You can also setup Pages to have preset sections and decide if you want the sections to be shared across pages.
``` yml
HomePage:
  section_options:
    BreadcrumbSection:
      limit: 0 # excluded from HomePage
    ContentSection:
      limit: 1 # Only 1 can ever be added
```

##### Add preset sections to page type
You can also setup Pages to have preset sections and decide if you want the sections to be shared across pages.

``` yml
FormPage:
  section_options:
    FormSection:
      presets:
        'Home Page Form': 'shared' # section is shared across home pages
        'Another Form': 'not-shared' # section is not shared across home pages
```
