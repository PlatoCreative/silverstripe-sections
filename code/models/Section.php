<?php
class Section extends DataObject
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
        'Style' => 'Text'
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
                    ->setDescription('This field is for adminisration use only and will not display on the site.')
                ),
                $tabSettings = new Tab(
                    'Settings',
                    TextField::create(
                        'MenuTitle',
                        'Menu title'
                    ),
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
        if ($this->MenuTitle) {
            return strtolower(str_replace(' ','',$this->MenuTitle));
        }else{
            return $this->Type.$this->ID;
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
        $classes = array(
            'section',
            strtolower(preg_replace('/([a-z]+)([A-Z0-9])/', '$1-$2', get_called_class()))
        );
        if ($this->Style) {
            $classes[] = strtolower($this->Style).'-section';
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
