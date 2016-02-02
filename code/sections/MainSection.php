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
        return 'id="main';
    }

    public function getCMSFields() {
        return false;
    }
}
