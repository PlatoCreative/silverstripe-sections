<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class LinkSection extends Section
{
    private static $title = "Linkable list items";

    private static $description = "";

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Title' => 'Text',
        'LinkType' => 'Enum("currentchildren,specify,children", "currentchildren")',
        'LinkLimit' => 'Int'
    );

    /**
    * Has one relationship
    * @var array
    */
    private static $has_one = array(
        'ParentPage' => 'Page'
    );

    /**
    * Many_many relationship
    * @var array
    */
    private static $many_many = array(
        'LinkList' => 'SectionsLink'
    );

    /**
     * {@inheritdoc }
     * @var array
     */
    private static $many_many_extraFields = array(
        'LinkList' => array(
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
        if ($this->LinkList()->Count() > 0) {
            $TeaserConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields->addFieldsToTab(
            'Root.Main',
            array(
                TextareaField::create(
                    'Title'
                )->setRows(1),
                DropdownField::create(
                    'LinkType',
                    'Type',
                    array(
                        "currentchildren" => "List all sub pages of this page",
                        "children" => "Specify a page and list all its sub pages",
                        "specify" => "Specify each link"
                    )
                ),
                DisplayLogicWrapper::create(
                    TreeDropdownField::create(
                        'ParentPageID',
                        'Select a page',
                        'SiteTree'
                    )
                )->displayIf("LinkType")->isEqualTo("children")->end(),
                DisplayLogicWrapper::create(
                    NumericField::create(
                        'LinkLimit',
                        'Limit links'
                    )
                    ->setDescription("0 equals unlimited amount.")
                )->displayIf("LinkType")->isNotEqualTo("specify")->end(),
                DisplayLogicWrapper::create(
                    GridField::create(
                        'LinkList',
                        'Current Link(s)',
                        $this->LinkList(),
                        $TeaserConfig
                    )
                )->displayIf("LinkType")->isEqualTo("specify")->end()
            )
        );

        $this->extend('UpdateCMSFields', $fields);
        
        return $fields;
    }

    public function ListLinks()
    {
        switch ($this->LinkType) {
            case 'specify':
                return $this->LinkList();
                break;
            case 'children':
                $currentPage = Director::get_current_page();
                return $this
                    ->ParentPage()
                    ->Children()
                    ->Limit($this->LinkLimit)
                    ->Exclude(
                        array(
                            "ID" => $currentPage->ID
                        )
                    );
                break;
            case 'currentchildren':
            default:
                $currentPage = Director::get_current_page();
                return $currentPage
                    ->Children()
                    ->Limit($this->LinkLimit);
                break;
        }
    }
}
