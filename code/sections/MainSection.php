<?php

/**
* Used as a placeholder for main content on the page.  Don't add anything to this file.
*/

class MainSection extends Section
{
    private static $title = "Placeholder for main content";

    private static $description = "";

    private static $minimum_per_page = 1;

    private static $maximum_per_page = 1;

    private static $selectable_option = false;
    
    /**
     * CMS Fields
     * @return FieldList
     */
    function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(array('Main','AdminTitle','MenuTitle','Public'));
        return $fields;
    }

    public function Layout()
    {
        $page = Director::get_current_page();
        $member = Member::currentUser();
        $access = Permission::checkMember($member, 'CMS_ACCESS');
        $sectionType = get_called_class();
        if($this->Public || $access){
            // Added UserDefinedForm to section
            if(in_array('UserDefinedForm', ClassInfo::ancestry($page->ClassName))){
                $result = new UserDefinedForm_Controller($page);
                $result->init();
                $page->Form = $result->Form();
            }
            return $page->renderWith($this->Render());
        }
    }

    public function GridFieldRowClasses(){
        return array('disabled', 'main');
    }
}
