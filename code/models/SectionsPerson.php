<?php
/**
 *
 *
 * @package silverstripe
 * @subpackage sections
 */
class SectionsPerson extends Dataobject
{
    /**
     * Singular name for CMS
     * @var string
     */
    private static $singular_name = "Person";

    /**
     * Plural name for CMS
     * @var string
     */
    private static $plural_name = "People";

    /**
     * Database fields
     * @var array
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
    * @var array
    */
    private static $has_one = array(
        'Image' => 'Image'
    );

    private static $summary_fields = array(
        "Image.CMSThumbnail" => "Image",
        "Title" => "Title",
        "Email" => "Email",
        "Phone" => "Phone",
        "Mobile" => "Mobile"
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
                )->setFolderName('Person'),
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
        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    /**
     * Viewing Permissions
     * @return boolean
     */
    public function canView($member = null)
    {
        return Permission::check('EDIT_SECTIONS', 'any', $member);
    }

    /**
     * Editing Permissions
     * @return boolean
     */
    public function canEdit($member = null)
    {
        return Permission::check('EDIT_SECTIONS', 'any', $member);
    }

    /**
     * Deleting Permissions
     * @return boolean
     */
    public function canDelete($member = null)
    {
        return Permission::check('EDIT_SECTIONS', 'any', $member);
    }

    /**
     * Creating Permissions
     * @return boolean
     */
    public function canCreate($member = null)
    {
        return Permission::check('EDIT_SECTIONS', 'any', $member);
    }

    public function Anchor(){
        if ($this->Name) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-',$this->Name), '-'));
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
