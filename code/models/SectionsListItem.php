<?php
/**
* List Item
*
* @package sectionlistitem
*/
class SectionsListItem extends DataObject
{
    /**
     * Singular name for CMS
     * @return string
     */
    private static $singular_name = 'Item';

    /**
     * Plural name for CMS
     * @return string
     */
    private static $plural_name = 'Items';

    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        "AdminTitle" => "Varchar(50)",
        "Status" => "Boolean",
        "Title" => "Varchar(100)",
        "Content" => "Text",
    );

    private static $has_one = array(
        "Image" => "Image"
    );

    private static $many_many = array(
        "Links" => "Link"
    );

    private static $many_many_extraFields = array(
        'Links' => array(
            'Sort' => 'Int'
        )
    );

    private static $summary_fields = array(
        "Image.CMSThumbnail" => "Image",
        "AdminTitle" => "Title",
        "NiceStatus" => "Status"
    );

    public function getCMSFields() {
        $linksGridConfig = GridFieldConfig_RelationEditor::create();
        if ($this->Links()->Count() > 0) {
            $linksGridConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                OptionsetField::create(
                    'Status',
                    'Status',
                    array(
                        "1" => "Active",
                        "0" => "Disabled"
                    ),
                    1
                ),
                TextField::create(
                    'AdminTitle'
                )
                ->setDescription('This field is for adminisration use only and will not display on the site.'),
                TextareaField::create(
                    'Title',
                    'Title'
                )
                ->setRows(2),
                TextareaField::create(
                    'Content',
                    'Content'
                ),
                UploadField::create(
                    'Image',
                    'Image'
                )
            )
        );
        return $fields;
    }

    public function getNiceStatus() {
        return ($this->Status == 1 ? "Active" : "Disabled");
    }

}
