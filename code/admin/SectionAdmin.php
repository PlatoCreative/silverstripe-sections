<?php
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class SectionAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = array(
        'Section'
    );

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'sections';

    /**
     * Menu title for CMS
     * @var string
     */
    private static $menu_title = 'All Sections';

}
