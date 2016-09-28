<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class PeopleSection extends Section
{
    private static $title = "List of people";

    private static $description = "";

    /**
     * Database fields
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(40)',
        'Content' => 'HTMLText'
    );

    /**
    * Many_many relationship
    * @var array
    */
    private static $many_many = array(
        'People' => 'SectionsPerson'
    );

    /**
     * {@inheritdoc }
     * @var array
     */
    private static $many_many_extraFields = array(
        'People' => array(
            'Sort' => 'Int'
        )
    );

    /**
     * CMS Fields
     * @return array
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $PeopleConfig = GridFieldConfig_RecordEditor::create();
        if ($this->People()->Count() > 0) {
            $PeopleConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields->addFieldsToTab(
            'Root.Main',
            array(
                TextareaField::create(
                    'Title'
                )->setRows(1),
                HTMLEditorField::create(
                    'Content'
                ),
                GridField::create(
                    'People',
                    'Current People(s)',
                    $this->People(),
                    $PeopleConfig
                )
            )
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }
}
