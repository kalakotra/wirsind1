<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Parsers\URLSegmentFilter;

class MemberExtension extends Extension
{

    private static $db = [
        'URLSegmentCompany' => 'Varchar',
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
        'IntroductionLogo' => 'Int', // 0 = FB Logo, 1 = Insta Logo, 2 = Kein Logo
        'IntroductionLink' => 'Varchar',
        'IntroductionLinkTitle' => 'Varchar',
        'Description' => 'HTMLText',
        'Text' => 'Text',
        'OldId' => 'Int',
        'OldText' => 'Text',
        'OldImageId' => 'Int',
        'OldIndustry' => 'Varchar',
        'OldRegion' => 'Varchar',
        'New' => 'Boolean',
        'Deactivated' => 'Boolean',
        'Changed' => 'Boolean',
        'SendInfoEmail' => 'Boolean',
        'EditedFromAdmin' => 'Boolean',
        'NoNewsletter' => 'Boolean',
        'ChangedFieldsText' => 'Text',
        'RegistrationToken' => 'Varchar(64)', // secret for the TempMemberID cookie during frontend registration
    ];

    private static $has_one = [
        'MemberIndustry' => MemberIndustry::class,
        'Image' => Image::class,
        'Video' => File::class
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
        //'myEditedFromAdmin' => 'Bearbeitet',
        'newsletterStatus' => 'Newsletter',
    ];

    private static $searchable_fields = [
        'Surname',
        'FirstName',
        
        'Email'
    ];

    private static $owns = [
        'Image'
    ];

    private static $field_labels = [
        'CompanyName' => 'Firmenname',
        'FirstName' => 'Vorname',
        'Surname' => 'Nachname',
        'Email' => 'E-Mail',
        'myNew' => 'Neu',
        'Changed' => 'Überarbeitet',
        'Deactivated' => 'Deaktiviert',
        'newsletterStatus' => 'Newsletter',
        'NoNewsletter' => 'Kein Newsletter',
        'Street' => 'Straße',
        'PostCode' => 'Postleitzahl',
        'City' => 'Ort',
        'Region' => 'Bezirk',
        'Telephone' => 'Telefonnummer',
        'Website' => 'Webseite',
        'SocialMedia' => 'Facebook',
        'Instagram' => 'Instagram',
        'LinkedIn' => 'LinkedIn',
        'TikTok' => 'TikTok',
        'OtherSocialMedia' => 'Youtube',
        'IntroductionLink' => 'Vorstellungslink',
        'IntroductionLinkTitle' => 'Vorstellungslink Titel',
        'IntroductionLogo' => 'Vorstellungslogo',
        'Description' => 'Beschreibung',
        'Text' => 'Text',
        'Preview' => 'Vorschau',
        'Image' => 'Profilbild',
        'MemberIndustry' => 'Branche',
        'EditedFromAdmin' => 'Bearbeitet (Website Umstellung)',
        'SendInfoEmail' => 'Aktivieren und Info E-Mail senden',
        'OldId' => 'Alte ID (nur für Admins)',
        'OldText' => 'Alter Text (nur für Admins)',
        'OldImageId' => 'Alte Bild ID (nur für Admins)',
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $fields->addFieldToTab("Root.Main", LiteralField::create("prevLink", "<a href='/epu-netzwerk/details/".$this->owner->ID."' target='_blank'><h3>Preview</h3></a>"), "CompanyName");

        $fields->addFieldToTab("Root.Main", UploadField::create("Image"));

        $fields->removeByName([
            'URLSegmentCompany',
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
            //'DirectGroups',
            'BlogProfileSummary',
            'New',
            'Deactivated',
            'Changed',
            'SendInfoEmail',
            'EditedFromAdmin',
            'ChangedFieldsText',
            'RegistrationToken',
        ]);

        $fields->renameField("SocialMedia", $this->owner->fieldLabel("SocialMedia"));
        $fields->renameField("Instagram", $this->owner->fieldLabel("Instagram"));
        $fields->renameField("OtherSocialMedia", $this->owner->fieldLabel("OtherSocialMedia"));
        $fields->renameField("IntroductionLogo", $this->owner->fieldLabel("IntroductionLogo"));
        $fields->renameField("IntroductionLink", $this->owner->fieldLabel("IntroductionLink"));
        
        $fields->addFieldToTab('Root.Main', DropdownField::create('IntroductionLogo', $this->owner->fieldLabel("IntroductionLogo"), [
            0 => 'Facebook Logo',
            1 => 'Instagram Logo',
            2 => 'Kein Logo'
        ]),
        'IntroductionLink');

        $fields->addFieldToTab('Root.Main', TextField::create('IntroductionLinkTitle', $this->owner->fieldLabel("IntroductionLinkTitle")), 'IntroductionLink');
        

        if ($this->owner->SendInfoEmail == 0 && $this->owner->New == 0) {
            $fields->addFieldToTab("Root.Main", CheckboxField::create("Deactivated", $this->owner->fieldLabel('Deactivated')), "CompanyName");
            $fields->addFieldToTab("Root.Main", CheckboxField::create("Changed", $this->owner->fieldLabel('Changed')), "CompanyName");
        } else {

            if ($this->owner->New == 1) {
                $fields->insertBefore("CompanyName", CheckboxField::create("SendInfoEmail", $this->owner->fieldLabel("SendInfoEmail")));
            } else {
                //$fields->addFieldToTab("Root.Main", CheckboxField::create("New", "Deactivate profile"), "CompanyName");
            }
        }

        $fields->addFieldToTab('Root.Main', HiddenField::create('InCMS', 'InCMS', 1));

        //$fields->insertBefore(CheckboxField::create("EditedFromAdmin", $this->owner->fieldLabel("EditedFromAdmin")), "CompanyName");
        $fields->insertBefore('CompanyName', CheckboxField::create('NoNewsletter', $this->owner->fieldLabel("NoNewsletter")));


        // add border to the fields listed in ChangedFieldsText
        $changedFields = explode(", ", $this->owner->ChangedFieldsText ?? '');
        foreach ($changedFields as $changedField) {
            $field = $fields->dataFieldByName($changedField);
            if ($field) {
                $field->setAttribute('style', 'border: 1px solid #ff0000;');
            }   
        }
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
        // check if something changed
        $changed = $this->owner->getChangedFields(true, DataObject::CHANGE_VALUE);

        if ($this->owner->URLSegmentCompany == "" && $this->owner->CompanyName != "") {
            $this->owner->URLSegmentCompany = $this->owner->generateURLSegmentCompany();
        }

        if ($this->owner->InCMS == 1) {
            $this->owner->ChangedFieldsText = "";
        } else {
            // if outside CMS, save changed fields to ChangedFieldsText. Don't overwrite actual changes made in CMS
            $this->owner->ChangedFieldsText .= implode(", ", array_keys($changed)) . ", ";
        }

        if (!empty($changed)) {

            // add MemberChange logs
            $memberChange = MemberChange::create();
            $memberChange->MemberID = $this->owner->ID;
            if (Security::getCurrentUser()) {
                $memberChange->ChangedFromID = Security::getCurrentUser()->ID;
            }
            $memberChange->ChangedFieldsText = implode(", ", array_keys($changed));
            $memberChange->InCMS = $this->owner->InCMS;
            $memberChange->write();

            if ($this->owner->New != 1) {
                if (isset($changed['Changed'])) {
                    if ($this->owner->InCMS == 1 && $this->owner->Changed == 0) {
                        // send email to user that profile is published
                        $config = SiteConfig::current_site_config();

                        $email = Email::create();
                        $email->setFrom('team@wirsind1.at');
                        $email->setTo($this->owner->Email);
                        $email->setBcc("office@seeyou.at");
                        $email->setSubject("Profil veröffentlicht");
                        $myText = str_replace("[NAME]", $this->owner->FirstName, DBField::create_field("HTMLText", $config->RegUserEmailProfileChangedVerified) );
                        $email->setBody($myText);
                        $email->send();
                    }
                } else {
                    if ($this->owner->InCMS == 0 && $this->owner->Changed == 1) {
                        // send email to admin that profile changed
                        $config = SiteConfig::current_site_config();

                        $email = Email::create();
                        $email->setFrom('no-reply@wirsind1.at');
                        $email->setTo('team@wirsind1.at');
                        $email->setBcc("office@seeyou.at");
                        $email->setSubject("Profil Überarbeitet");
                        $myText = str_replace("[CHANGED]", '<a href="/admin/profiles/profiles/EditForm/field/profiles/item/'.$this->owner->ID.'/edit">Hier klicken</a>', DBField::create_field("HTMLText", $config->RegAdminEmailProfileChanged) );
                        $email->setBody($myText);
                        //$email->send();

                        //$this->owner->Changed = 1;
                    }

                    
                }
            } else {
                $this->owner->Changed = 0;
            }
        }

        if ($this->owner->SendInfoEmail == 1) {

            $config = SiteConfig::current_site_config(); 

            $email = Email::create();
            $email->setFrom('team@wirsind1.at');
            $email->setTo($this->owner->Email);
            //$email->setTo("kalakotra@gmail.com");
            $email->setSubject((string) $config->RegMailPublicTitle); 

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

    public function generateURLSegmentCompany()
    {
        $filter = URLSegmentFilter::create();
        $name = $this->owner->CompanyName;
        $urlSegment = $filter->filter($name);

        if (!$urlSegment || $urlSegment == '-' || $urlSegment == '-1') {
            $urlSegment = 'profile-' . $this->owner->ID;
        }

        return $urlSegment;
    }

    public function myNew() {
        if ($this->owner->Deactivated == 1) {
            return "Deactivated";
        } else {
            if ($this->owner->New == 1) {
                return "Neu";
            } elseif ($this->owner->Changed == 1) {
                return "Überarbeitet";
            } else {
                return "Veröffentlicht";
            }
        }
    }

    public function newsletterStatus() {
        if ($this->owner->NoNewsletter == 1) {
            return "Nein";
        } else {
            return "Ja";
        }
    }


    public function myEditedFromAdmin() {
        if ($this->owner->EditedFromAdmin == 1) {
            return "Bearbeitet";
        } else {
            
        }
    }

    public function checkURL($urlStr) {
        $urlStr = trim((string) $urlStr);
        $parsed = parse_url($urlStr);
        // only allow http(s) links, everything else (e.g. javascript:) is treated as a host name
        if (empty($parsed['scheme']) || !in_array(strtolower($parsed['scheme']), ['http', 'https'])) {
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
