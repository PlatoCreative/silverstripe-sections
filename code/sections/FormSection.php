<?php
class FormSection extends Section
{
    /**
     * Database fields
     * @return array
     */
    private static $db = array();

    /**
     * Has_one relationship
     * @return array
     */
    private static $has_one = array(
        'FormPage' => 'UserDefinedForm'
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                DropdownField::create(
                    'FormPageID',
                    'Select a page',
                    UserDefinedForm::get()->map('ID', 'Title')
                )
            )
        );
        return $fields;
    }

    public function Title()
    {
        if ($this->FormPage()) {
            $result = new UserDefinedForm_Controller($this->FormPage());
            $result->init();
            return $result->Title;
        }
        return false;
    }

    public function Content()
    {
        if ($this->FormPage()) {
            $result = new UserDefinedForm_Controller($this->FormPage());
            $result->init();
            return $result->Content;
        }
        return false;
    }

    public function Form()
    {
        if ($this->FormPage()) {
            $result = new UserDefinedForm_Controller($this->FormPage());
            $result->init();
            return $result->Form();
        }
        return false;
    }
}
