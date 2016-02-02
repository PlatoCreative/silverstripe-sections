<?php
/**
* Banner
*
* @package sectionbanner
*/
class Banner extends DataObject
{
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

    private static $summary_fields = array(
        "Image.CMSThumbnail" => "Image",
        "AdminTitle" => "Title",
        "NiceStatus" => "Status"
    );

    /**
    * @param Member $member
    *
    * @return boolean
    */
    public function canEdit($member = null) {
        return ($this->canEdit($member));
    }

    /**
    * @param Member $member
    *
    * @return boolean
    */
    public function canDelete($member = null) {
        return ($this->canDelete($member));
    }

    public function getCMSFields() {
        $fields = new FieldList(
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
            )->setDescription(""),
            TextareaField::create(
                'Title',
                'Title'
            )
                ->setRows(2)
                ->setDescription(""),
            TextareaField::create(
                'Content',
                'Content'
            )->setDescription(""),
            UploadField::create(
                'Image',
                'Image'
            )->setFolderName("Banner")
        );
        return $fields;
    }

    public function getNiceStatus() {
        return ($this->Status == 1 ? "Active" : "Disabled");
    }

}
