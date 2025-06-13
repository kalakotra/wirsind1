<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class CustomSiteConfig extends DataExtension
{

    private static $db = [
        'RegAfterText' => 'HTMLText',
        'RegEmailTitle' => 'Varchar',
        'RegEmailText' => 'HTMLText',
        'RegMailPublicTitle' => 'Varchar',
        'RegMailPublicText' => 'HTMLText',
        'RegMailOneDayTitle' => 'Varchar',
        'RegMailOneDayText' => 'HTMLText',
        'RegAdminEmailTitle' => 'Varchar',
        'RegAdminEmailText' => 'HTMLText',
        'RegAllreadyRegistered' => 'HTMLText',
        'RegIfChangedDeactivated' => 'HTMLText',
    ];

    private static $has_one = [
        
    ];

    private static $has_many = [

    ];

    private static $many_many = [

    ];

    private static $many_many_extraFields = [

    ];

    private static $owns = [
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $config = GridFieldConfig_RecordEditor::create(); 
        $config->addComponent(GridFieldOrderableRows::create('Sort'));

        $gridField = GridField::create('FooterLogo', 'FooterLogo', FooterLogo::get(), $config);
        $fields->addFieldToTab("Root.Footer", $gridField);

        $config = GridFieldConfig_RecordEditor::create(); 
        $gridField = GridField::create('MemberIndustry', 'MemberIndustry', MemberIndustry::get(), $config);
        $fields->addFieldToTab("Root.Industry", $gridField);

        $fields->addFieldsToTab("Root.Registration", [
            HTMLEditorField::create("RegAfterText", "Text after registration")->addExtraClass("stacked"),

            LiteralField::create("sep1", "<h1>Registration E-Mail</h1>"),
            TextField::create("RegEmailTitle", "Subject"),
            HTMLEditorField::create("RegEmailText", "Text")->addExtraClass("stacked"),
            TextField::create("RegAdminEmailTitle", "Subject - Admin"),
            HTMLEditorField::create("RegAdminEmailText", "Text - Admin")->addExtraClass("stacked"),

            LiteralField::create("sep2", "<h1>Profile published - E-Mail</h1>"),
            TextField::create("RegMailPublicTitle", "Subject"),
            HTMLEditorField::create("RegMailPublicText", "Text")->addExtraClass("stacked"),

            LiteralField::create("sep3", "<h1>After 3 days - E-Mail</h1>"),
            TextField::create("RegMailOneDayTitle", "Subject"),
            HTMLEditorField::create("RegMailOneDayText", "Text")->addExtraClass("stacked"),

            LiteralField::create("sep4", "<h1>E-Mail is registered</h1>"),
            HTMLEditorField::create("RegAllreadyRegistered", "Text")->addExtraClass("stacked")

        ]);

        $fields->addFieldsToTab("Root.Profile", [
            HTMLEditorField::create("RegIfChangedDeactivated", "Profile change - deactivate")->addExtraClass("stacked")
        ]);
    }
}
