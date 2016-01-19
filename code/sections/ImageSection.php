<?php
class ImageSection extends Section
{
    /**
    * Many_many relationship
    * @return array
    */
    private static $many_many = array(
        'Images' => 'Image'
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
                UploadField::create(
                    'Images',
                    'Current Image(s)',
                    $this->Images()
                )
            )
        );
        return $fields;
    }
}
