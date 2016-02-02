<?php
class TeaserSection extends Section
{
    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        'Title' => 'Text',
        'TeaserType' => 'Enum(array("List","Children"),"List")',
    );

    /**
    * Has one relationship
    * @return array
    */
    private static $has_one = array(
        'ParentPage' => 'Page'
    );

    /**
    * Many_many relationship
    * @return array
    */
    private static $many_many = array(
        'TeaserList' => 'Teaser'
    );

    private static $many_many_extraFields = array(
        'TeaserList' => array(
            'Sort' => 'Int'
        )
    );

    /**
     * CMS Fields
     * @return array
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $TeaserConfig = GridFieldConfig_RecordEditor::create();
        if ($this->TeaserList()->Count() > 0) {
            $TeaserConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields->addFieldsToTab(
            'Root.Main',
            array(
                TextareaField::create(
                    'Title'
                )->setRows(1),
                DropdownField::create(
                    'TeaserType',
                    'Type',
                    singleton('TeaserSection')
                        ->dbObject('TeaserType')
                        ->enumValues()
                ),
                TreeDropdownField::create(
                    'ParentPageID',
                    'Select a page',
                    'SiteTree'
                )->displayIf("TeaserType")->isEqualTo("Children")->end(),
                GridField::create(
                    'TeaserList',
                    'Current Teaser(s)',
                    $this->Teaser(),
                    $TeaserConfig
                )->displayIf("TeaserType")->isEqualTo("List")->end()
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
