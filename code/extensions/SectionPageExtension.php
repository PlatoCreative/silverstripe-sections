<?php
/**
 * Adds sections to each page.
 *
 * @package silverstripe-sections
 */
class SectionPageExtension extends DataExtension
{
    /**
     * Has_one relationship
     * @return array
     */
    private static $has_one = array(
        "PreviewImage" => "Image"
    );

    /**
     * Has_many relationship
     * @return array
     */
    private static $many_many = array(
        'Sections' => 'Section'
    );

    private static $many_many_extraFields = array(
        'Sections' => array(
            'Sort' => 'Int'
        )
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    function updateCMSFields(FieldList $fields)
    {
        if (!Permission::check("VIEW_SECTIONS")) {
            return $fields;
        }

        $SectionGrid = GridFieldConfig_RelationEditor::create()
            ->removeComponentsByType('GridFieldAddNewButton')
            ->addComponent(new GridFieldAddNewMultiClass())
            ->addComponent(new GridFieldOrderableRows());

        $SectionGrid->getComponentByType('GridFieldAddExistingAutocompleter')
            ->setSearchFields(array('AdminTitle'))
            ->setResultsFormat('$AdminTitle');

        $SectionSubClasses = ClassInfo::subclassesfor('Section');
        unset($SectionSubClasses['Section'], $SectionSubClasses['MainSection']);
        foreach ($SectionSubClasses as $key => $value) {
            $SectionSubClasses[$key] = Section::Type($value);
        }

        # Limit sections based on type
        $LimitSectionTypes = Config::inst()->get($this->owner->ClassName, 'LimitSectionTypes');
        // debug::dump($LimitSectionTypes);
        if ($LimitSectionTypes) {
            foreach ($LimitSectionTypes as $type => $value) {
                if ($value == 0) {
                    unset($SectionSubClasses[$type]);
                    continue;
                }
                $CurrentSectionCount = $this->owner->Sections()->filter('ClassName', $type)->count();
                if ($CurrentSectionCount >= $value) {
                    unset($SectionSubClasses[$type]);
                    continue;
                }
            }
        }

        $SectionGrid->getComponentByType('GridFieldAddNewMultiClass')
        ->setClasses($SectionSubClasses);

        # Limit total sections
        $LimitSectionTotal = Config::inst()->get($this->owner->ClassName, 'LimitSectionTotal');
        // debug::dump($PageLimits);
        if (isset($LimitSectionTotal) && $this->owner->Sections()->Count() >= $LimitSectionTotal) {
            // remove the buttons if we don't want to allow more records to be added/created
            $SectionGrid->removeComponentsByType('GridFieldAddNewButton');
            $SectionGrid->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $SectionGrid->removeComponentsByType('GridFieldAddNewMultiClass');
        }

        if (!Permission::check("LINK_SECTIONS")) {
            $SectionGrid->removeComponentsByType('GridFieldAddExistingAutocompleter');
        }

        if (!Permission::check("REORDER_SECTIONS")) {
            $SectionGrid->removeComponentsByType('GridFieldOrderableRows');
        }

        if (!Permission::check("UNLINK_SECTIONS")) {
            $SectionGrid->removeComponentsByType('GridFieldDeleteAction');
        }

        $fields->addFieldToTab(
            'Root.Section',
            GridField::create(
                'Sections',
                'Current Section(s)',
                $this->owner->Sections(),
                $SectionGrid
            )
        );

        $fields->addFieldToTab(
            'Root.Preview',
            UploadField::create(
                'PreviewImage',
                'Preview image'
            )
        );

        return $fields;
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();
        if($this->owner->Sections()->Count() == 0){
            $section = Section::get()
                ->filter(
                    array(
                        'ClassName' => 'MainSection'
                    )
                )
                ->first();
            if ($section) {
                $this->owner->Sections()->add($section->ID);
            }else{
                $section = MainSection::create();
                $section->AdminTitle = 'Placeholder for main content';
                $section->Public = true;
                $section->Write();
                $this->owner->Sections()->add($section);
            }
        }
    }

    public function Sections(){
        // return $this->Sections()->renderWith('Sections');
    }

    public function LinkURL(){
        return $this->owner->Link();
    }
}
