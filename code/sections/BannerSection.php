<?php
class BannerSection extends Section
{

    /**
     * Has_many relationship
     * @return array
     */
    private static $many_many = array(
        "Banners" => "SectionsBanner"
    );

    /**
     * {@inheritdoc }
     * @return array
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
        return $fields;
    }
}
