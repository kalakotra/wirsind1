<?php

use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DB;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\Director;
use Silverstripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBField;

class MemberExtension extends DataExtension
{

    private static $db = [
        'CompanyName' => 'Varchar',
        'Street' => 'Varchar',
        'PostCode' => 'Varchar',
        'City' => 'Varchar',
        'Region' => 'Enum("Amstetten,Baden,Bruck a.d. Leitha,Gänserndorf,Gmünd,Hollabrunn,Horn,Korneuburg,Krems Land,Krems Stadt,Lilienfeld,Melk,Mistelbach,Mödling,Neunkirchen,Scheibbs,Sankt Pölten Land,Sankt Pölten Stadt,Tulln,Waidhofen a.d. Thaya,Waidhofen a.d. Ybbs,Wiener Neustadt Land,Wiener Neustadt Stadt,Zwettl,Kein Bezirk", "Kein Bezirk")',
        'Telephone' => 'Varchar',
        'Website' => 'Varchar',
        'SocialMedia' => 'Varchar', // facebook
        'Instagram' => 'Varchar',
        'LinkedIn' => 'Varchar',
        'TikTok' => 'Varchar',
        'OtherSocialMedia' => 'Varchar', // Youtube
        'IntroductionLink' => 'Varchar',
        'Description' => 'HTMLText',
        'Text' => 'Text',
        'OldId' => 'Int',
        'OldText' => 'Text',
        'OldImageId' => 'Int',
        'OldIndustry' => 'Varchar',
        'OldRegion' => 'Varchar',
        'New' => 'Boolean',
        'Deactivated' => 'Boolean',
        'SendInfoEmail' => 'Boolean',
        'EditedFromAdmin' => 'Boolean'
    ];

    private static $has_one = [
        'MemberIndustry' => MemberIndustry::class,
        'Image' => Image::class
    ];

    private static $has_many = [

    ];

    private static $many_many = [

    ];

    private static $summary_fields = [
        'Created' => 'Created',
        'CompanyName' => 'CompanyName',
        'FirstName' => 'FirstName',
        'Surname' => 'Surname',
        'Email' => 'Email',
        'myNew' => 'New',
        'myEditedFromAdmin' => 'Bearbeitet'
    ];

    private static $searchable_fields = [
        'Surname',
        'FirstName',
        
        'Email'
    ];

    private static $owns = [
        'Image'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        

        $fields->addFieldToTab("Root.Main", LiteralField::create("prevLink", "<a href='/epu-netzwerk/details/".$this->owner->ID."' target='_blank'><h3>Preview</h3></a>"), "CompanyName");

        $fields->addFieldToTab("Root.Main", UploadField::create("Image"));

        $fields->removeFieldsFromTab("Root.Main", [
            'OldId',
            'OldText',
            'OldImageId',
            'OldIndustry',
            'OldRegion',
            //'Password',
            'Locale',
            'FailedLoginCount',
            'BlogProfileSummary',
            'BlogProfileImage',
            'DirectGroups',
            'BlogProfileSummary',
            'New',
            'Deactivated',
            'SendInfoEmail',
            'EditedFromAdmin'
        ]);

        if ($this->owner->SendInfoEmail == 0 && $this->owner->New == 0) {
            $fields->addFieldToTab("Root.Main", CheckboxField::create("Deactivated", "Deactivate profile"), "CompanyName");
        } else {

            if ($this->owner->New == 1) {
                $fields->addFieldToTab("Root.Main", CheckboxField::create("SendInfoEmail", "Activate and send info Email"), "CompanyName");
            } else {
                //$fields->addFieldToTab("Root.Main", CheckboxField::create("New", "Deactivate profile"), "CompanyName");
            }
        }

        $fields->addFieldToTab("Root.Main", CheckboxField::create("EditedFromAdmin", "Bearbeitet (Website Umstellung)"), "CompanyName");

        $fields->renameField("SocialMedia", "Facebook-Link");
        $fields->renameField("Instagram", "Instagram-Link");
        $fields->renameField("OtherSocialMedia", "Weiterer Social Media-Link");

        $fields->addFieldToTab("Root.Main", TextareaField::create("Description"), "Text");
        
    }
    public function updateMyImage() {
        $myImage = Image::get()->filter(["Name" => $this->owner->OldImageId.".jpg"]);
        if ( $myImage->exists() ) {
            $myImage = $myImage->First();
            //$this->owner->Image()->add($myImage);
            //$this->owner->write();
            //echo 'UPDATE Member SET ImageID='.$myImage.' WHERE ID='.$this->owner."<-- <br />";
            //DB::query('UPDATE Member SET ImageID='.$myImage->ID.' WHERE ID='.$this->owner->ID);
            return $myImage;
        }
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();

        if ($this->owner->SendInfoEmail == 1) {

            $config = SiteConfig::current_site_config(); 

            $email = Email::create();
            $email->setFrom('team@wirsind1.at');
            $email->setTo($this->owner->Email);
            //$email->setTo("kalakotra@gmail.com");
            $email->setSubject($config->RegMailPublicTitle); 

            /* if problematic than casting DBField::create_field("HTMLText", "")*/
            $myText = str_replace("[NAME]", $this->owner->FirstName, DBField::create_field("HTMLText", $config->RegMailPublicText) );
            //$myText = str_replace("[image src", '<img src="https://wirsind1.at', $config->RegMailPublicText);
            //$myText = str_replace("]", ">", $config->RegMailPublicText);
            //$myText = $this->imagesToBase64($myText);
            $email->setBody($myText);

            $email->send();

            $this->owner->SendInfoEmail = 0;
            $this->owner->New = 0;
            
        }
    }

    public function myNew() {
        if ($this->owner->Deactivated == 1) {
            return "Deactivated";
        } else {
            if ($this->owner->New == 1) {
                return "New";
            } else {
                return "";
            }
        }
    }


    public function myEditedFromAdmin() {
        if ($this->owner->EditedFromAdmin == 1) {
            return "Bearbeitet";
        } else {
            
        }
    }

    public function checkURL($urlStr) {
        $parsed = parse_url($urlStr);
        if (empty($parsed['scheme'])) {
            $urlStr = 'http://' . ltrim($urlStr, '/');
        }

        return $urlStr;
    }

    public function imagesToBase64($html = "") {
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            $src = "http://".Director::host().$image->getAttribute('src');
            $type = pathinfo($src, PATHINFO_EXTENSION);
            $data = file_get_contents($src);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $image->setAttribute("src", $base64); 
            $image->setAttribute("data-info", "wshr"); 
        }
        $html = $dom->saveHTML();

        return $html;
    }
}
