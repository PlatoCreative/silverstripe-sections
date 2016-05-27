<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class BannerSection extends Section
{
    private static $title = "Rotating banner";

    private static $description = "";

    /**
     * Has_many relationship
     * @var array
     */
    private static $many_many = array(
        "Banners" => "SectionsBanner"
    );

    /**
     * {@inheritdoc }
     * @var array
     */
    private static $many_many_extraFields = array(
        "Banners" => array(
            "Sort" => "Int"
        )
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $bannerGridConfig = GridFieldConfig_RelationEditor::create();
        if ($this->Banners()->Count() > 0) {
            $bannerGridConfig->addComponent(new GridFieldOrderableRows());
        }

        $fields->addFieldToTab(
            'Root.Main',
            GridField::create(
                'Banners',
                'Banner',
                $this->Banners(),
                $bannerGridConfig
            )
        );

        $this->extend('UpdateCMSFields', $fields);
        
        return $fields;
    }
}
