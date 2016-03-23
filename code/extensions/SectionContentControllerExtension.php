<?php
class SectionContentControllerExtension extends Extension {

    /**
    * @var array
    */
    private static $allowed_actions = array(
        'handleSection'
    );

    /**
     * Handles section attached to a page
     * Assumes URLs in the following format: <URLSegment>/section/<section-id>.
     *
     * @return RequestHandler
     */
    public function handleSection() {

        if ($ClassName = $this->owner->getRequest()->param('SECTIONNAME')) {
            $sections = $this->owner->data()->Sections();
            if ($section = $sections->filter(array('ClassName' => $ClassName))->first()) {
                if ($action = $this->owner->getRequest()->param('ACTION')) {
                    return $section->getController()->$action();
                }
            }
        }
        // return $section->getController();
    }

}
