<?php
class SectionsPerson extends Dataobject
{
    /**
     * Singular name for CMS
     * @return string
     */
    private static $singular_name = "Person";

    /**
     * Plural name for CMS
     * @return string
     */
    private static $plural_name = "People";

    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        "Name" => "Text",
        "Title" => "Text",
        "Email" => "Text",
        "Phone" => "Text",
        "Mobile" => "Text",
        "Description" => "HTMLText"
    );

    /**
    * Has one relationship
    * @return array
    */
    private static $has_one = array(
        'Image' => 'Image'
    );

    /**
     * CMS Fields
     * @return array
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                UploadField::create(
                    'Image'
                ),
                TextField::create(
                    'Name'
                ),
                TextField::create(
                    'Title'
                ),
                TextField::create(
                    'Email'
                ),
                TextField::create(
                    'Phone'
                ),
                TextField::create(
                    'Mobile'
                ),
                HTMLEditorField::create(
                    'Description'
                ),
            )
        );
        return $fields;
    }

    public function Anchor(){
        if ($this->Name) {
            return strtolower(str_replace(' ','',$this->Name));
        }
        return false;
    }

    public function AnchorAttr(){
        if ($this->Anchor()) {
            return 'id="'.$this->Anchor().'"' ;
        }
        return false;
    }
}
