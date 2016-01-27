<?php
class BannerSection extends Section
{
    /**
     * Has_many relationship
     * @return array
     */
    private static $many_many = array(
        "Banners" => "Banner"
    );

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

        $bannerGridConfig = GridFieldConfig_RelationEditor::create()
            ->addComponent(new GridFieldOrderableRows());

        $fields->addFieldToTab(
            'Root.Banner',
            GridField::create(
                'Banners',
                'Banner',
                $this->Banners(),
                $bannerGridConfig
            )
        );
        return $fields;
    }
}
