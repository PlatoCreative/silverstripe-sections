<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class QuoteSection extends Section
{
    private static $title = "Quote";

    private static $description = "";

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Quote' => 'Text',
        'Citation' => 'Text'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                TextareaField::create(
                    'Quote'
                ),
                TextareaField::create(
                    'Citation'
                )
                ->setRows(1)
                ->setDescription('Who cited/quoted this?')
            )
        );

        $this->extend('UpdateCMSFields', $fields);
        
        return $fields;
    }
}
