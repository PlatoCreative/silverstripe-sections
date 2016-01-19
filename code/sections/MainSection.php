<?php

/**
* Used as a placeholder for main content on the page.  Don't add anything to this file.
*/

class MainSection extends Section
{
    public function Anchor(){
        return 'main';
    }

    public function AnchorAttr(){
        return 'id="main' ;
    }

    public function Layout()
    {
        $page = Director::get_current_page();
        $member = Member::currentUser();
        $access = Permission::checkMember($member, 'CMS_ACCESS');
        $sectionType = get_called_class();
        if($this->Public || $access){
            $renderWith = array(
                $sectionType.'_'.$page->ClassName,
                $sectionType,
                'DefaultSection'
            );
            return $page->renderWith($renderWith);
        }
    }
}
