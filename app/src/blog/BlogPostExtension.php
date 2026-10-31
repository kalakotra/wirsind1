<?php

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class BlogPostExtension extends Extension
{

    private static $db = [
        'Subtitle' => 'Varchar'
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
        

        $fields->addFieldToTab("Root.Main", TextField::create("Subtitle"), "Content");

        $fields->removeFieldFromTab("Root.PostOptions", "Tags");
        $fields->removeFieldFromTab("Root.PostOptions", "AuthorNames");
    }
}
