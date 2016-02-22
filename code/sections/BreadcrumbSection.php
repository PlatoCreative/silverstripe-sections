<?php
class BreadcrumbSection extends Section
{
    private static $title = "Breadcrumb";

    /**
     * Database fields
     * @return array
     */
    private static $db = array(
        "ShowHome" => "Boolean"
    );

    /**
     * CMS Fields
     * @return FieldList
     */
    function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            "Root.Main",
            array(
                DropdownField::create(
                    'ShowHome',
                    'Show home',
                    array(
                        "1" => "Yes",
                        "0" => "No"
                    ),
                    1
                )
            )
        );
        return $fields;
    }
}
