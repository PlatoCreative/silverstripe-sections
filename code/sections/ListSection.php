<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class ListSection extends Section
{
    private static $title = "Definition List";

    private static $description = "";

    /**
     * Has_many relationship
     * @var array
     */
    private static $many_many = array(
        "Items" => "SectionsListItem"
    );

    /**
     * {@inheritdoc }
     * @var array
     */
    private static $many_many_extraFields = array(
        "Items" => array(
            "Sort" => "Int"
        )
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $listGridConfig = GridFieldConfig_RelationEditor::create();
        if ($this->Items()->Count() > 0) {
            $listGridConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields->addFieldToTab(
            'Root.Main',
            GridField::create(
                'Items',
                'List',
                $this->Items(),
                $listGridConfig
            )
        );

        $this->extend('UpdateCMSFields', $fields);
        
        return $fields;
    }
}
