<?php
class ContentSection extends Section
{
    private static $title = "General content";

    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        'Title' => 'Varchar(40)',
        'Content' => 'HTMLText'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                TextareaField::create(
                    'Title'
                )->setRows(1),
                HTMLEditorField::create(
                    'Content'
                )
            )
        );
        return $fields;
    }
}
