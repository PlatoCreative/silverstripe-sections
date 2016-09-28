<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class ImageBannerSection extends Section
{
    private static $title = "Rotating image banner";

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
        'Images' => 'Image',
        "Links" => "Link"
    );

    /**
     * {@inheritdoc }
     * @var array
     */
    private static $many_many_extraFields = array(
        'Images' => array(
            'SortOrder' => 'Int'
        ),
        'Links' => array(
            'Sort' => 'Int'
        )
    );

    /**
     * CMS Fields
     * @return array
     */
    public function getCMSFields()
    {
        $linksGridConfig = GridFieldConfig_RelationEditor::create();
        if ($this->Links()->Count() > 0) {
            $linksGridConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                TextareaField::create(
                    'Title'
                )->setRows(1),
                HTMLEditorField::create(
                    'Content'
                ),
                SortableUploadField::create(
                    'Images',
                    'Current Image(s)'
                ),
                GridField::create(
                    'Links',
                    'Links',
                    $this->Links(),
                    $linksGridConfig
                )
            )
        );

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }
}
