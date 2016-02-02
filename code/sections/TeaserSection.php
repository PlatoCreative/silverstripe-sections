<?php
class TeaserSection extends Section
{
    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        'Title' => 'Text',
        'TeaserType' => 'Enum(array("default",list","children"),"default")',
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
                    array(
                        "default" => "List all sub pages of this page",
                        "children" => "Specify a page and list all its sub pages",
                        "list" => "Specify each teaser"
                    )
                ),
                DisplayLogicWrapper::create(
                    TreeDropdownField::create(
                        'ParentPageID',
                        'Select a page',
                        'SiteTree'
                    )
                )->displayIf("TeaserType")->isEqualTo("children")->end(),
                DisplayLogicWrapper::create(
                    GridField::create(
                        'TeaserList',
                        'Current Teaser(s)',
                        $this->TeaserList(),
                        $TeaserConfig
                    )
                )->displayIf("TeaserType")->isEqualTo("list")->end()
            )
        );
        return $fields;
    }

    public function ListTeasers()
    {
        switch ($this->TeaserType) {
            case 'list':
                return $this->TeaserList();
                break;
            case 'Children':
                $currentPage = Director::get_current_page();
                return $this
                    ->ParentPage()
                    ->Children()
                    ->Exclude(
                        array(
                            "ID" => $currentPage->ID
                        )
                    );
                break;
            case 'default':
            default:
                $currentPage = Director::get_current_page();
                return $currentPage->Children();
                break;
        }
    }
}
