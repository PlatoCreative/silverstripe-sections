<?php
class ImageSection extends Section
{
    private static $title = "Image separator";

    private static $description = "";

    /**
    * Many_many relationship
    * @return array
    */
    private static $many_many = array(
        'Images' => 'Image'
    );

    /**
     * {@inheritdoc }
     * @return array
     */
    private static $many_many_extraFields = array(
        'Images' => array(
            'SortOrder' => 'Int'
        )
    );

    /**
     * CMS Fields
     * @return array
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                SortableUploadField::create(
                    'Images',
                    'Current Image(s)'
                )
            )
        );
        return $fields;
    }
}
