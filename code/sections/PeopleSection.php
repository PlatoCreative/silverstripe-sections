<?php
class PeopleSection extends Section
{
    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        'Title' => 'Varchar(40)',
        'Content' => 'HTMLText'
    );

    /**
    * Many_many relationship
    * @return array
    */
    private static $many_many = array(
        'People' => 'Person'
    );

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
                    'Current People',
                    $this->People(),
                    $PeopleConfig
                )
            )
        );
        return $fields;
    }
}
