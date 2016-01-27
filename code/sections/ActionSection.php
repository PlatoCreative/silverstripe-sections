<?php
class ActionSection extends Section
{
    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        'Title' => 'Text'
    );

    /**
    * Has one relationship
    * @return array
    */
    private static $has_one = array(
        'ParentPage' => 'Page'
    );

    /**
     * CMS Fields
     * @return array
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            array(
                TextareaField::create(
                    'Title'
                )->setRows(1),
                TreeDropdownField::create(
                    'ParentPageID',
                    'Select a page',
                    'SiteTree'
                )
            )
        );
        return $fields;
    }

    public function Children(){
        $currentPage = Director::get_current_page();
        return $this
            ->ParentPage()
            ->Children()
            ->Exclude(
                array(
                    "ID" => $currentPage->ID
                )
            );
    }
}
