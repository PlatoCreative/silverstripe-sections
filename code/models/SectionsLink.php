<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class SectionsLink extends Link
{
    /**
     * Singular name for CMS
     * @var string
     */
    private static $singular_name = "Link";

    /**
     * Plural name for CMS
     * @var string
     */
    private static $plural_name = "Links";

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        "Content" => "Text",
        "ReadMore" => "Text"
    );

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = array(
        "PreviewImage" => "Image"
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->addFieldsToTab(
            "Root.Main",
            array(
                TextareaField::create(
                    'Content',
                    'Content'
                ),
                UploadField::create(
                    'PreviewImage',
                    'Image'
                )->setFolderName('Preview')
            ),
            'Type'
        );

        $fields->addFieldsToTab(
            "Root.Main",
            array(
                TextField::create(
                    'ReadMore',
                    'Read more'
                )
            )
        );
        $this->extend('updateCMSFields', $fields);
        return $fields;
    }
}
