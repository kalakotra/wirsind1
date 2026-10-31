<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;

    class Page extends SiteTree
    {
        private static $db = [
            'HeaderSubtitle' => 'Text',
            'ShowInFooter' => 'Boolean',
            'CustomHTML' => 'HTMLText'
        ];

        private static $has_one = [
            'PageHeaderImage' => Image::class
        ];

        public function getSettingsFields() {
            $fields = parent::getSettingsFields();

            $fields->addFieldToTab("Root.Settings", CheckboxField::create("ShowInFooter"), "ShowInMenus");

            return $fields;
        }

        public function getCMSFields() {
            $fields = parent::getCMSFields();
            $fields->addFieldToTab('Root.Main', TextareaField::create('HeaderSubtitle', 'Subtitle'), 'Content');

            if ($this->ClassName == "SilverStripe\Blog\Model\Blog" ) {
                $fields->removeFieldFromTab("Root.Main", "Content");
            } else {
                //$fields->addFieldToTab('Root.Custom', UploadField::create('PageHeaderImage', 'Page Header Image'), 'Content');
                
                $fields->addFieldToTab('Root.Custom', TextareaField::create('CustomHTML', 'Custom HTML')->setRows(10)->setDescription('eg. custom IFrame'));
            }

            if ($this->ClassName == "SilverStripe\Blog\Model\BlogPost" ) {
                $fields->removeByName([
                    'HeaderSubtitle',
                    'Custom'
                ]);
            }

            return $fields;
        }
    }
}
