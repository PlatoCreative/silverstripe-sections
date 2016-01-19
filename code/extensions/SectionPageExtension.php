<?php
/**
 * Adds sections to each page.
 *
 * @package silverstripe-sections
 */
class SectionPageExtension extends DataExtension
{
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
    function getCMSFields()
    {
        $fields = parent::getCMSFields();

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
            $SectionSubClasses[$key] = Section::NiceType($value);
        }

        $SectionGrid->getComponentByType('GridFieldAddNewMultiClass')
        ->setClasses($SectionSubClasses);

        $fields->addFieldToTab(
            'Root.Section',
            GridField::create(
                'Sections',
                'Current Section(s)',
                $this->Sections(),
                $SectionGrid
            )
        );

        return $fields;
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();
        if($this->Sections()->Count() == 0){
            $section = Section::get()
                ->filter(
                    array(
                        'ClassName' => 'MainSection'
                    )
                )
                ->first();
            if ($section) {
                $this->Sections()->add($section->ID);
            }else{
                $section = MainSection::create();
                $section->AdminTitle = 'Placeholder for main content';
                $section->Public = true;
                $section->Write();
                $this->Sections()->add($section);
            }
        }
    }
}
