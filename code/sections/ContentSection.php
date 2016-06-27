<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class ContentSection extends Section
{
    private static $title = "General content";

    private static $description = "";

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Title' => 'Text',
        'Content' => 'HTMLText'
    );

    /**
     * CMS Fields
     * @var FieldList
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

        $this->extend('UpdateCMSFields', $fields);
        
        return $fields;
    }
}
