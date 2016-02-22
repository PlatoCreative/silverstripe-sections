<?php
class Section extends DataObject implements PermissionProvider
{
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
        'Public' => 'Boolean',
        'Style' => 'Text',
        "ShowInMenus" => "Boolean"
    );

    private static $defaults = array(
        "ShowInMenus" => 1,
        "Public" => 1
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
                    CheckboxField::create(
                        'ShowInMenus',
                        'Show in menus',
                        1
                    ),
                    DisplayLogicWrapper::create(
                        TextField::create(
                            'MenuTitle',
                            'Navigation label'
                        )
                    )->displayIf("ShowInMenus")->isChecked()->end()
                ),
                $tabSettings = new Tab(
                    'Settings',
                    CheckboxField::create(
                        'Public',
                        'Public',
                        1
                    )
                    ->setDescription('Is this section publicly accessible?.'),
                    DropdownField::create(
                        'Style',
                        'Select a style',
                        $this->ConfigStyles
                    )
                    ->setEmptyString('Default')
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
        'Type' => 'Type'
    );

    /**
     * Searchable Fields
     * @return array
     */
    public static $searchable_fields = array(
        'AdminTitle',
        'MenuTitle'
    );


    /**
     * Permissions
     * @return array
     */
    public function providePermissions() {
        return array(
            "VIEW_SECTIONS" => array(
                'name' => 'View any sections',
                'help' => 'Allow users to view any sections on a page',
                'category' => 'Sections',
                'sort' => 88
            ),
            "CREATE_SECTIONS" => array(
                'name' => 'Create sections',
                'help' => 'Allow users to create new sections on pages',
                'category' => 'Sections',
                'sort' => 90
            ),
            "EDIT_SECTIONS" => array(
                'name' => 'Edit sections',
                'help' => 'Allow users to edit existing sections',
                'category' => 'Sections',
                'sort' => 92
            ),
            "DELETE_SECTIONS" => array(
                'name' => 'Delete sections',
                'help' => 'Allow users to delete sections from pages',
                'category' => 'Sections',
                'sort' => 94
            ),
            "LINK_SECTIONS" => array(
                'name' => 'Link existing sections',
                'help' => 'Allow users to link existing sections to a page',
                'category' => 'Sections',
                'sort' => 96
            ),
            "REORDER_SECTIONS" => array(
                'name' => 'Change order of sections',
                'help' => 'Allow users to change the order of existing sections on a page',
                'category' => 'Sections',
                'sort' => 100
            )
        );
    }

    /**
     * Viewing Permissions
     */
    public function canView($member = null) {
        return Permission::check('VIEW_SECTIONS', 'any', $member);
    }

    /**
     * Editing Permissions
     * @return boolean
     */
    public function canEdit($member = null) {
        return Permission::check('EDIT_SECTIONS', 'any', $member);
    }

    /**
     * Deleting Permissions
     * @return boolean
     */
    public function canDelete($member = null) {
        return Permission::check('DELETE_SECTIONS', 'any', $member);
    }

    /**
     * Creating Permissions
     * @return boolean
     */
    public function canCreate($member = null) {
        return Permission::check('CREATE_SECTIONS', 'any', $member);
    }

    public function getConfigStyles(){
        $config_styles = Config::inst()->get(get_called_class(), 'styles');
        if ($config_styles) {
            foreach ($config_styles as $value) {
                $styles[$value] = preg_replace('/([a-z]+)([A-Z0-9])/', '$1 $2', $value);
            }
            return $styles;
        }
        return array();
    }

    public static function Type($ClassName = NULL){
        if (!$ClassName) {
            $ClassName = get_called_class();
        }
        return trim(preg_replace('/([A-Z])/', ' $1', str_ireplace('Section', '', $ClassName)));
    }

    public function Anchor(){
        if ($this->MenuTitle && $this->ShowInMenus) {
            return strtolower(str_replace(' ','',$this->MenuTitle));
        }
        return false;
    }

    public function AnchorAttr(){
        if ($this->Anchor()) {
            return ' id="'.$this->Anchor().'"';
        }
        return false;
    }

    public function Classes(){
        $classes = array('section');
        if ($this->Style) {
            $classes[] = strtolower($this->Style).'-'.strtolower(preg_replace('/([a-z]+)([A-Z0-9])/', '$1-$2', get_called_class()));
        }else{
            $classes[] = strtolower(preg_replace('/([a-z]+)([A-Z0-9])/', '$1-$2', get_called_class()));
        }
        return implode(' ',$classes);
    }

    public function ClassAttr(){
        return 'class="'.$this->Classes().'"';
    }

    public function Render(){
        $page = Director::get_current_page();
        $styleType = ($this->Style ? '_'.$this->Style : '');
        $pageType = ($page->ClassName ? '_'.$page->ClassName : '');
        $sectionType = get_called_class();
        return array(
            $sectionType.$pageType.$styleType,
            $sectionType.$styleType,
            $sectionType.$pageType,
            $sectionType,
            'DefaultSection'
        );
    }

    public function Layout()
    {
        $member = Member::currentUser();
        $access = Permission::checkMember($member, 'CMS_ACCESS');
        if($this->Public || $access){
            return $this->renderWith($this->Render());
        }
    }
}
