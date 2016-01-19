<?php
class TeamSection extends Section
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
        'Team' => 'SectionPerson'
    );

    private static $many_many_extraFields = array(
        'Team' => array(
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

        $TeamConfig = GridFieldConfig_RecordEditor::create();
		if ($this->Team()->Count() > 0) {
			$TeamConfig->addComponent(new GridFieldOrderableRows());
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
                    'Team',
                    'Current People',
                    $this->Team(),
                    $TeamConfig
                )
            )
        );
        return $fields;
    }
}
