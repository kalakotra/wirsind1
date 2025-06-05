<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Forms\PasswordField;
    use SilverStripe\View\Requirements;
    use SilverStripe\View\SSViewer;
    use SilverStripe\Security\Group;
    use SilverStripe\Security\Member;
    use SilverStripe\ORM\FieldType\DBField;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\RequiredFields;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FileField;
    use Silverstripe\SiteConfig\SiteConfig;
    use SilverStripe\Control\Email\Email;
    use SilverStripe\Control\Director;
    use SilverStripe\Control\Cookie;

    class FormularPageController extends FilterPageController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [
            'ProfileForm',
            'finishAddingProfile'
        ];


        public function ProfileForm() {

            $myRegions = Member::singleton()->dbObject('Region')->enumValues();
            //$myRegions = $this->getAllMemberRegions();
            

            $fields = FieldList::create(
                TextField::create('CompanyName', '')->setAttribute("placeholder", "Name deines Unternehmens*"),
                DropdownField::create('MemberIndustryID', '', MemberIndustry::get()->map())->setEmptyString("Branche wählen...*"),
                TextField::create('FirstName', '')->setAttribute("placeholder", "Vorname*"),
                TextField::create('Surname', '')->setAttribute("placeholder", "Nachname*"),
                TextField::create('Street', '')->setAttribute("placeholder", "Straße / Nr.*"),
                TextField::create('PostCode', '')->setAttribute("placeholder", "PLZ*"),
                TextField::create('City', '')->setAttribute("placeholder", "Ort*"),
                $myRegion = DropdownField::create('Region', '', $myRegions)->setEmptyString("Bezirk wählen...*"),
                $email = EmailField::create('Email', '')->setAttribute("placeholder", "E-Mail*"),
                TextField::create('Telephone', '')->setAttribute("placeholder", "Telefonnummer"),
                TextField::create('Website', '')->setAttribute("placeholder", "Website"),
                FileField::create('Image', '')->setAttribute("placeholder", "Foto hochladen"),
                TextField::create('SocialMedia', '')->setAttribute("placeholder", "Facebook-Link"),
                TextField::create('Instagram', '')->setAttribute("placeholder", "Instagram-Link"),
                TextField::create('LinkedIn', '')->setAttribute("placeholder", "LinkedIn-Link"),
                TextField::create('TikTok', '')->setAttribute("placeholder", "TikTok-Link"),
                //TextField::create('Youtube', '')->setAttribute("placeholder", "Youtube-Link"),
                TextField::create('OtherSocialMedia', '')->setAttribute("placeholder", "Youtube-Link"),
                TextareaField::create('Description', '')->setAttribute("placeholder", "Unternehmensbeschreibung*"),
                TextareaField::create('Text', '')->setAttribute("placeholder", "Was macht dich als UnternehmerIn aus? Was treibt dich an? Was motiviert dich jeden Tag?*"),

                
                
                TextField::create('Betreff', '')->setAttribute("placeholder", "Betreff"),
                TextField::create('Subject', '')->setAttribute("placeholder", "Subject"),
                
                CheckboxField::create("datenschutz", DBField::create_field("HTMLFragment", 'Ich stimme der Veröffentlichung meines Beitrags auf dieser Website und der Verarbeitung meiner hier angegebenen Daten und meiner Aktivitätsdaten in dieser Kampagne laut den <a href="datenschutz/" target="_blank" class="text-body"><u>Bestimmungen zum Datenschutz</u></a> zur Durchführung von Kampagnen ausdrücklich zu und möchte per E-Mail am Laufenden gehalten werden. Diese Zustimmung kann ich jederzeit widerrufen.'))
            ); 

            $actions = FieldList::create(
                $myReset = FormAction::create('resetProfileForm', _t("ProfileForm.Reset",'Abbrechen'))->setAttribute('type', 'reset')->addExtraClass("btn btn-outline-dark rounded-pill px-4"),
                $myAction = FormAction::create('submitProfileForm', _t("ProfileForm.Submit",'Weiter'))->addExtraClass("btn btn-dark rounded-pill px-4")
            );

            $validator = RequiredFields::create('CompanyName', 'MemberIndustryID', 'FirstName', 'Surname', 'Region', 'Street', 'PLZ', 'City', 'Email', 'Image', 'Description', 'Text', 'datenschutz');

            $form = Form::create($this, __FUNCTION__, $fields, $actions, $validator); 

            $form->setTemplate("ProfileForm");
            
            if ($myMember = $this->getCurrentMember()) {
                if ($myMember->Image()->exists()) {
                    $fields->push(HiddenField::create("FotoID","FotoID", $myMember->Image()->FocusFill(150,150)->URL));
                    $validator->removeRequiredField("Image");
                }
                $fields->push(HiddenField::create("ID"));
                $form->loadDataFrom($myMember);

                $email->setDisabled(true);
                $email->setReadonly(true);

                $myAction->setTitle(_t("ProfileForm.Update",'Ändern'));
                $myReset->setDisabled(true);
                $myReset->setReadonly(true);
                $myReset->addExtraClass("d-none");

                if ($myMember->Region != "") {
                    $myRegion->setValue($myMember->Region);
                } else {
                    $myRegion->setValue("Kein Bezirk");
                }
            } else {
                if ($myMemberID = Cookie::get("TempMemberID")) {
                    if ($myMember = Member::get()->byId($myMemberID) ) {
                        if ($myMember->Image()->exists()) {
                            $fields->push(HiddenField::create("FotoID","FotoID", $myMember->Image()->FocusFill(150,150)->URL));
                            $validator->removeRequiredField("Image");
                        }
                        $fields->push(HiddenField::create("ID"));
                        $form->loadDataFrom($myMember);
                        
                    }             
                }

                $fields->push(
                    PasswordField::create('Password', '')->setAttribute("placeholder", "Passwort*")
                );

                $validator->addRequiredField("Password");
            }

            return $form;
        }

        public function submitProfileForm($data, $form) {
            if ($data["Subject"] != "") {
                $this->redirect("home/");
            } else {
                if ($myMember = $this->getCurrentMember()) { 
                    if ($myMember->ID == $data["ID"]) {
                        $form->saveInto($myMember);
                        $myMember->write();
                        $myMember->inEdit = true;
                        return $this->customise($myMember)->renderWith("Page");
                    }
                } else {
                    $config = SiteConfig::current_site_config(); 
                    /* check if email exists */
                    $myMember = Member::get()->filter("Email", $data["Email"]);
                    $myPostId = 0;
                    if (isset($data["ID"]) ) {
                        $myPostId = $data["ID"];
                    }
                    if ($myMember->exists() && $myPostId == 0 ) {
                        /* ovde umjesto redirekcije poslati poruku nazad da ima korisnik */
                        $myData = [
                            'ProfileForm' => DBField::create_field("HTMLText", $config->RegAllreadyRegistered),
                            'Content' => $config->RegAllreadyRegistered
                        ];

                        return $myData;
                    } else {
                        if ($myPostId > 0) {
                            $myMember = Member::get()->byId($myPostId);
                        } else {
                            $myMember = Member::create();
                        }
                        
                        
                        $form->saveInto($myMember);

                        $myMember->write();

                        Cookie::set("TempMemberID", $myMember->ID);

                        /*$myMember->Groups()->add(3);
                        $myMember->New = 1;
                        $myMember->write();*/

                        /* move files to upload folder !!!! */

                        /*$email = Email::create();
                        $email->setFrom('team@wirsind1.at');
                        $email->setTo($myMember->Email);
                        $email->setSubject($config->RegEmailTitle); */

                        /* if problematic than casting DBField::create_field("HTMLText", "")*/
                        /*$myText = str_replace("[NAME]", $myMember->FirstName, DBField::create_field("HTMLText", $config->RegEmailText) );
                        $email->setBody($myText);
                        $email->send();*/

                        
                        /* send email to all admins */
                        /*
                        $myAdminGroup = Group::get()->byId(2);

                        $myAdminEmails = "";
                        foreach ($myAdminGroup->Members() as $key => $value) {
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                
                                if ($myAdminEmails == "" ) {
                                    $myAdminEmails = $value->Email;
                                } else {
                                    $myAdminEmails .= ",".$value->Email;
                                }
                            }
                        }
                        */
                        //if ($myAdminEmails != "" ) {
                            // admin email send only on team@wirsind1.at
                            /*$email = Email::create();
                            $email->setFrom('no-reply@'.Director::host());
                            //$email->setTo($myAdminEmails);
                            $email->setTo("team@wirsind1.at");
                            $email->setBcc("office@seeyou.at");
                            $email->setSubject($config->RegAdminEmailTitle); */

                            /* if problematic than casting DBField::create_field("HTMLText", "")*/
                            //$email->setBody($config->RegAdminEmailText);

                            //$email->send();
                        //}

                        /*$myData = [
                            'ProfileForm' => DBField::create_field("HTMLText", $config->RegAfterText),
                            'Content' => $config->RegAfterText
                        ];

                        return $myData;*/
                        $myMember->inEdit = true;
                        return $this->customise($myMember)->renderWith("Page");
                    }

                }
            }
        }

        public function finishAddingProfile() {
            $config = SiteConfig::current_site_config();

            if ($myMember = $this->getCurrentMember()) {
                
            } else {
                // get member form cookie
                $myMemberID = Cookie::get("TempMemberID");
                $myMember = Member::get()->byId($myMemberID);
                Cookie::force_expiry("TempMemberID");

                $myMember->Groups()->add(3);
                $myMember->New = 1;
                $myMember->write();

                /* move files to upload folder !!!! */

                /*$email = Email::create();
                $email->setFrom('team@wirsind1.at');
                $email->setTo($myMember->Email);
                $email->setSubject($config->RegEmailTitle); */

                /* if problematic than casting DBField::create_field("HTMLText", "")*/
                /*$myText = str_replace("[NAME]", $myMember->FirstName, DBField::create_field("HTMLText", $config->RegEmailText) );
                $email->setBody($myText);
                $email->send();*/


                $email = Email::create();
                $email->setFrom('no-reply@'.Director::host());
                //$email->setTo($myAdminEmails);
                $email->setTo("team@wirsind1.at");
                $email->setBcc("office@seeyou.at");
                $email->setSubject($config->RegAdminEmailTitle); 

                /* if problematic than casting DBField::create_field("HTMLText", "")*/
                $email->setBody($config->RegAdminEmailText);

                $email->send();

                $myData = [
                    'ProfileForm' => DBField::create_field("HTMLText", $config->RegAfterText),
                    'Content' => $config->RegAfterText
                ];

                return $myData;
            }

        }
        
    }
}
