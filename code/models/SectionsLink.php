<?php
/**
* Custom link
*/
class SectionsLink extends Link
{
    /**
     * Singular name for CMS
     * @return string
     */
    private static $singular_name = "Link";

    /**
     * Plural name for CMS
     * @return string
     */
    private static $plural_name = "Links";

    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        "Content" => "Text",
        "ReadMore" => "Text"
    );

    /**
     * Has_one relationship
     * @return array
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
                )
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
        return $fields;
    }
}
