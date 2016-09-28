<?php

class Section_Controller extends Controller
{
    /**
     * @var $section
     */
    protected $section;

    /*
     * @param Section $section
     */
     public function __contruct($section = null)
     {
         if ($section) {
             $this->section = $section;
             $this->failover = $section;
         }
         $this->CurrentPage = Controller::curr();
         parent::__contruct();
     }

     public function index()
     {
         return;
     }

     /**
     * @param string $action
     *
     * @return string
     */
    public function Link($action = null)
    {
        $id = ($this->section) ? $this->section->ID : null;
        $segment = Controller::join_links('section', $id, $action);
        if ($page = Director::get_current_page()) {
            return $page->Link($segment);
        }
        return Controller::curr()->Link($segment);
    }

    /**
     * Access current page scope from section templates with $CurrentPage
     *
     * @return Controller
     */
    public function getCurrentPage()
    {
        return Controller::curr();
    }

     public function getSection()
     {
         return $this->section;
     }
}
