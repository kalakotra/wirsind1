<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\CheckboxField;

    class Page extends SiteTree
    {
        private static $db = [
            'ShowInFooter' => 'Boolean'
        ];

        private static $has_one = [];

        public function getSettingsFields() {
            $fields = parent::getSettingsFields();

            $fields->addFieldToTab("Root.Settings", CheckboxField::create("ShowInFooter"), "ShowInMenus");

            return $fields;
        }

        public function getCMSFields() {
            $fields = parent::getCMSFields();

            if ($this->ClassName == "SilverStripe\Blog\Model\Blog" ) {
                $fields->removeFieldFromTab("Root.Main", "Content");
            }

            return $fields;
        }
    }
}
