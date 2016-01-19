<?php
class Section extends DataObject {

    /**
     * Singular name for CMS
     * @return string
     */
    private static $singular_name = 'Section';

    /**
     * Plural name for CMS
     * @return string
     */
    private static $plural_name = 'Sections';

    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        'AdminTitle' => 'Varchar(30)',
        'MenuTitle' => 'Varchar(30)',
        'Public' => 'Boolean'
    );

    /**
     * Belongs_many_many relationship
     * @return array
     */
    private static $belongs_many_many = array(
        'Pages' => 'Page'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields() {
        return new FieldList(
            $rootTab = new TabSet(
                "Root",
                $tabMain = new Tab(
                    'Main',
                    TextField::create(
                        'AdminTitle',
                        'Admin title'
                    )
                    ->setDescription('This field is for adminisration use only and will not display on the site.'),
                    TextField::create(
                        'MenuTitle',
                        'Menu title'
                    ),
                    CheckboxField::create(
                        'Public',
                        'Public',
                        1
                    )
                    ->setDescription('Is this section publicly accessible?.')
                )
            )
        );
    }

    /**
     * Summary Fields
     * @return array
     */
    public static $summary_fields = array(
        'AdminTitle' => 'Title',
        'NiceType' => 'Type',
        'NicePublic' => 'Public'
    );

    /**
     * Searchable Fields
     * @return array
     */
    public static $searchable_fields = array(
        'AdminTitle'
    );

    /**
     * Viewing Permissions
     */
    public function canView($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    /**
     * Editing Permissions
     * @return boolean
     */
    public function canEdit($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    /**
     * Deleting Permissions
     * @return boolean
     */
    public function canDelete($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    /**
     * Creating Permissions
     * @return boolean
     */
    public function canCreate($member = null) {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public static function Type(){
        return get_called_class();
    }

    public static function NiceType($ClassName = NULL){
        if (!$ClassName) {
            $ClassName = get_called_class();
        }
        return trim(preg_replace('/([A-Z])/', ' $1', str_ireplace('Section', '', $ClassName)));
    }

    public function NicePublic(){
        if ($this->Public) {
            return 'Yes';
        }
        return 'No';
    }

    public function Anchor(){
        if ($this->MenuTitle) {
            return strtolower(str_replace(' ','',$this->MenuTitle));
        }
        return false;
    }

    public function AnchorAttr(){
        if ($this->Anchor()) {
            return 'id="'.$this->Anchor().'"' ;
        }
        return false;
    }

    public function Layout(){
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
            return $this->renderWith($renderWith);
        }
    }
}
