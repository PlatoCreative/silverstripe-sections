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
            ->setSearchFields(array('AdminTitle', 'MenuTitle'))
            ->setResultsFormat('$AdminTitle - $Type');

        $AvailableTypes = $this->AvailableSectionTypes();

        foreach ($AvailableTypes as $key => $value) {
            if($AvailableTypes[$key]['selectable_option'] != false){
                $AvailableTypes[$key] = $AvailableTypes[$key]['type'];
            }
        }

        $SectionGrid->getComponentByType('GridFieldAddNewMultiClass')
        ->setClasses($AvailableTypes);

        # Limit total sections
        $LimitSectionTotal = Config::inst(

        )->get($this->owner->ClassName, 'LimitSectionTotal');
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

        $AvailableTypes = $this->AvailableSectionTypes();
        foreach ($AvailableTypes as $key => $value) {
            $SectionCount = $this->owner->Sections()
                ->filter(
                    array(
                        'ClassName' => $AvailableTypes[$key]['classname']
                    )
                )
                ->Count();
            if($AvailableTypes[$key]['minimum_per_page'] > $SectionCount){
                $ClassName = $AvailableTypes[$key]['classname'];
                $section = $this->owner->Sections()
                    ->filter(
                        array(
                            'ClassName' => $ClassName
                        )
                    )
                    ->first();

                if ($section) {
                    $this->owner->Sections()->add($section->ID);
                }else{
                    $section = $ClassName::create();
                    $section->AdminTitle = $AvailableTypes[$key]['type'];
                    $section->Public = true;
                    $section->Write();
                    $this->owner->Sections()->add($section);
                }
            }
        }
    }

    public function AvailableSectionTypes()
    {
        $AvailableTypes = ClassInfo::subclassesfor('Section');
        unset($AvailableTypes['section']);
        foreach ($AvailableTypes as $key => $value) {
            $Config = Config::inst();
            $selectable_option = true;
            if ($Config->get($value, 'selectable_option') !== null) {
                $selectable_option = $Config->get($value, 'selectable_option');
            }
            $AvailableTypes[$key] = array(
                'classname' => $value,
                'type' => Section::Type($value),
                'minimum_per_page' => ($Config->get($value, 'minimum_per_page') !== null ?: 0),
                'maximum_per_page' => ($Config->get($value, 'maximum_per_page') !== null ?: 0),
                'selectable_option' => $selectable_option
            );
        }

        # Limit sections based on type
        $LimitSectionTypes = Config::inst()->get($this->owner->ClassName, 'LimitSectionTypes');
        if ($LimitSectionTypes) {
            foreach ($LimitSectionTypes as $type => $value) {
                if ($value == 0) {
                    unset($AvailableTypes[$type]);
                    continue;
                }
                $CurrentSectionCount = $this->owner->Sections()->filter('ClassName', $type)->count();
                if ($CurrentSectionCount >= $value) {
                    unset($AvailableTypes[$type]);
                    continue;
                }
            }
        }

        return $AvailableTypes;
    }

    public function Sections(){
        // return $this->Sections()->renderWith('Sections');
    }

    public function LinkURL(){
        return $this->owner->Link();
    }
}
