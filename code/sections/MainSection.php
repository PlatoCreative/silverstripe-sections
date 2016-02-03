<?php

/**
* Used as a placeholder for main content on the page.  Don't add anything to this file.
*/

class MainSection extends Section
{
    public function getCMSFields() {
        return false;
    }

    public function Layout()
    {
        $page = Director::get_current_page();
        $member = Member::currentUser();
        $access = Permission::checkMember($member, 'CMS_ACCESS');
        $sectionType = get_called_class();
        if($this->Public || $access){
            return $page->renderWith($this->Render());
        }
    }
}
