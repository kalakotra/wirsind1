<?php

namespace {

    use SilverStripe\Forms\ConfirmedPasswordField;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\View\SSViewer;
    use SilverStripe\Security\Group;
    use SilverStripe\Security\Member;
    use SilverStripe\ORM\FieldType\DBField;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\Validation\RequiredFieldsValidator;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FileField;
    use SilverStripe\SiteConfig\SiteConfig;
    use SilverStripe\Control\Email\Email;
    use SilverStripe\Control\Director;
    use SilverStripe\Control\Cookie;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorConfig;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorSanitiser;
    use SilverStripe\View\Parsers\HTMLValue;

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
            'finishAddingProfile',
            'finishEditingProfile',
            'PasswordChangeForm'
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
                $email = EmailField::create('Email', 'E-Mail*'), //->setAttribute("placeholder", "E-Mail*"),
                TextField::create('Telephone', '')->setAttribute("placeholder", "Telefonnummer"),
                TextField::create('Website', '')->setAttribute("placeholder", "Website"),
                FileField::create('Image', '')->setAttribute("placeholder", "Foto hochladen")->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'webp']),
                $videoField = FileField::create('Video', '')->setAttribute("placeholder", "Video hochladen"),
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

            $videoField->setAllowedExtensions(array('mp4'));
            // video set max file size to 100mb
            $videoField->getValidator()->setAllowedMaxFileSize(100 * 1024 * 1024);

            $actions = FieldList::create(
                $myReset = FormAction::create('resetProfileForm', _t("ProfileForm.Reset",'Abbrechen'))->setAttribute('type', 'reset')->addExtraClass("btn btn-outline-dark rounded-pill px-4"),
                $myAction = FormAction::create('submitProfileForm', _t("ProfileForm.Submit",'Weiter'))->addExtraClass("btn btn-dark rounded-pill px-4")
            );

            $validator = RequiredFieldsValidator::create('CompanyName', 'MemberIndustryID', 'FirstName', 'Surname', 'Region', 'Street', 'PLZ', 'City', 'Email', 'Image', 'Description', 'Text', 'datenschutz');

            $form = Form::create($this, __FUNCTION__, $fields, $actions, $validator); 

            $form->setTemplate("ProfileForm");
            
            if ($myMember = $this->getCurrentMember()) {
                if ($myMember->Image()->exists()) {
                    $fields->push(HiddenField::create("FotoID","FotoID", $myMember->Image()->FocusFill(150,150)->URL));
                    $validator->removeRequiredField("Image");
                }
                if ($myMember->VideoID > 0) {
                    $fields->push(HiddenField::create("VideoPreviewID","VideoID", $myMember->Video()->URL));
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

                /*$fields->push(
                    $passField = ConfirmedPasswordField::create('Password', 'Passwort*', null, null, false, 'Passwort bestätigen*')->setRequireExistingPassword(true)->setDescription("Das Passwort muss mindestens 8 Zeichen lang sein.")
                        //->setAttribute("placeholder", "z.B. 12345678")
                );*/
                /*$passField = $myMember->getMemberPasswordField();
                $passField->setDescription("Das Passwort muss mindestens 8 Zeichen lang sein.");
                $validator->removeRequiredField("Password");
                $fields->push($passField);*/
            } else {
                if ($myMember = $this->getTempMember()) {
                    if ($myMember->Image()->exists()) {
                        $fields->push(HiddenField::create("FotoID","FotoID", $myMember->Image()->FocusFill(150,150)->URL));
                        $validator->removeRequiredField("Image");
                    }
                    if ($myMember->VideoID > 0) {
                        $fields->push(HiddenField::create("VideoPreviewID","VideoID", $myMember->Video()->URL));
                    }
                    $fields->push(HiddenField::create("ID"));

                    $fields->push(
                        HiddenField::create("TempMemberID","TempMemberID", $myMember->ID)
                    );

                    $validator->removeRequiredField("Email");

                    $fields->removeByName("Password");
                    $fields->removeByName("Email");

                    $form->loadDataFrom($myMember);
                } else {
                    $fields->push(
                        ConfirmedPasswordField::create('Password', 'Passwort*', null, null, false, 'Passwort bestätigen*')->setDescription("Das Passwort muss mindestens 8 Zeichen lang sein.")
                            //->setAttribute("placeholder", "z.B. 12345678")
                    );

                    $validator->addRequiredField("Password");
                }
            }

            return $form;
        }

        public function submitProfileForm($data, $form) {
            if (!empty($data["Subject"])) {
                $this->redirect("home/");
            } else {
                $config = SiteConfig::current_site_config();


                if ($myMember = $this->getCurrentMember()) { 
                    if ($myMember->ID == $data["ID"]) {
                        if ($myMember->Changed == 0) {
                            // inform admin about changes
                            $email = Email::create();
                            $email->setFrom('no-reply@'.Director::host());
                            //$email->setTo($myAdminEmails);
                            $email->setTo("team@wirsind1.at");
                            $email->setBcc("office@seeyou.at");
                            $email->setSubject($config->RegAdminEmailTitle . " - Edit - " . $myMember->FirstName . " " . $myMember->Surname);

                            // add admin link to edit member
                            $email->setBody(
                                DBField::create_field("HTMLText", $config->RegAdminEmailText) .
                                "<br><br>" .
                                "<a href='" . Director::absoluteBaseURL() . "/admin/profiles/profiles/EditForm/field/profiles/item/" . $myMember->ID . "/edit' target='_blank'>Edit Member</a>"
                            );

                            /* if problematic than casting DBField::create_field("HTMLText", "")*/
                            //$email->setBody($config->RegAdminEmailText);

                            //$email->send();

                            $config = SiteConfig::current_site_config();

                            $email = Email::create();
                            $email->setFrom('no-reply@'.Director::host());
                            $email->setTo('team@wirsind1.at');
                            $email->setBcc("office@seeyou.at");
                            $email->setSubject("Profil Überarbeitet");
                            $myText = str_replace("[CHANGED]", '<a href="/admin/profiles/profiles/EditForm/field/profiles/item/'.$myMember->ID.'/edit">Hier klicken</a>', DBField::create_field("HTMLText", $config->RegAdminEmailProfileChanged) );
                            $email->setBody($myText);
                            $email->send();
                        }
                         
                        $form->saveInto($myMember);
                        $this->sanitiseProfileHtml($myMember);
                        $myMember->inEdit = true;
                        //$myMember->Deactivated = true;
                        $myMember->Changed = true;
                        $myMember->write();
                        
                        return $this->customise($myMember)->renderWith("Page");
                    }
                } else {
                    // registration in progress: the member comes only from the signed cookie, never from POST data
                    if ($myMember = $this->getTempMember()) {
                        $form->saveInto($myMember);
                        $this->sanitiseProfileHtml($myMember);

                        $myMember->write();

                        $this->rememberTempMember($myMember);

                        $myMember->inEdit = true;
                        return $this->customise($myMember)->renderWith("Page");
                    } else {

                        /* check if email exists */
                        $myMember = Member::get()->filter("Email", $data["Email"] ?? '');
                        if ($myMember->exists()) {
                            /* ovde umjesto redirekcije poslati poruku nazad da ima korisnik */
                            $myData = [
                                'ProfileForm' => DBField::create_field("HTMLText", $config->RegAllreadyRegistered),
                                'Content' => $config->RegAllreadyRegistered
                            ];

                            return $myData;
                        } else {
                            // always a new member here - a posted ID must never select an existing account
                            $myMember = Member::create();

                            $form->saveInto($myMember);
                            $this->sanitiseProfileHtml($myMember);
                            $myMember->RegistrationToken = bin2hex(random_bytes(32));

                            $myMember->write();

                            $this->rememberTempMember($myMember);
                            //$rememberMe = (isset($data['Remember']) && Security::config()->get('autologin_enabled'));
                            //$identityStore = Injector::inst()->get(IdentityStore::class);
                            //$identityStore->logIn($myMember, $rememberMe, $this->getRequest());

                            
                            $myMember->inEdit = true;
                            return $this->customise($myMember)->renderWith("Page");
                        }
                    }

                }
            }
        }

        public function finishAddingProfile() {
            $config = SiteConfig::current_site_config();

            if ($myMember = $this->getCurrentMember()) {
                $myMemberID = Cookie::get("TempMemberID");
                if ($myMemberID) {
                    $this->forgetTempMember();

                    $myMember->Groups()->add(3);
                    $myMember->New = 1;
                    $myMember->write();

                    $email = Email::create();
                    $email->setFrom('no-reply@'.Director::host());
                    //$email->setTo($myAdminEmails);
                    $email->setTo("team@wirsind1.at");
                    $email->setBcc("office@seeyou.at");
                    $email->setSubject((string) $config->RegAdminEmailTitle); 

                    /* if problematic than casting DBField::create_field("HTMLText", "")*/
                    $email->setBody($config->RegAdminEmailText .
                                "<br><br>" .
                                "<a href='" . Director::absoluteBaseURL() . "/admin/profiles/profiles/EditForm/field/profiles/item/" . $myMember->ID . "/edit' target='_blank'>Edit Member</a>");

                    $email->send();
                }
            } else {
                // get member form cookie
                $myMember = $this->getTempMember();
                if ($myMember) {
                    $this->forgetTempMember();

                    $myMember->Groups()->add(3);
                    $myMember->New = 1;
                    $myMember->RegistrationToken = null;
                    $myMember->write();

                    /* move files to upload folder !!!! */

                    /*$email = Email::create();
                    $email->setFrom('team@wirsind1.at');
                    $email->setTo($myMember->Email);
                    $email->setSubject((string) $config->RegEmailTitle); */

                    /* if problematic than casting DBField::create_field("HTMLText", "")*/
                    /*$myText = str_replace("[NAME]", $myMember->FirstName, DBField::create_field("HTMLText", $config->RegEmailText) );
                    $email->setBody($myText);
                    $email->send();*/


                    $email = Email::create();
                    $email->setFrom('no-reply@'.Director::host());
                    //$email->setTo($myAdminEmails);
                    $email->setTo("team@wirsind1.at");
                    $email->setBcc("office@seeyou.at");
                    $email->setSubject((string) $config->RegAdminEmailTitle); 

                    /* if problematic than casting DBField::create_field("HTMLText", "")*/
                    $email->setBody($config->RegAdminEmailText);

                    $email->send();

                    $myData = [
                        'ProfileForm' => DBField::create_field("HTMLText", $config->RegAfterText),
                        'Content' => $config->RegAfterText,
                        'HideHierAnmelden' => true
                    ];

                    return $myData;
                } else {
                    return $this->redirect("home/");
                }
            }

            $myData = [
                'ProfileForm' => DBField::create_field("HTMLText", $config->RegIfChangedDeactivated),
                'Content' => $config->RegIfChangedDeactivated
            ];

            return $myData;

        }

        /**
         * Member whose registration is in progress in this browser. The TempMemberID cookie is only
         * trusted together with the matching secret TempMemberToken cookie.
         */
        protected function getTempMember() {
            $myMemberID = (int) Cookie::get("TempMemberID");
            $token = (string) Cookie::get("TempMemberToken");
            if (!$myMemberID || $token === '') {
                return null;
            }

            $myMember = Member::get()->byID($myMemberID);
            if (!$myMember || !$myMember->RegistrationToken || !hash_equals((string) $myMember->RegistrationToken, $token)) {
                return null;
            }

            return $myMember;
        }

        protected function rememberTempMember($myMember) {
            Cookie::set("TempMemberID", (string) $myMember->ID);
            Cookie::set("TempMemberToken", (string) $myMember->RegistrationToken);
        }

        protected function forgetTempMember() {
            Cookie::force_expiry("TempMemberID");
            Cookie::force_expiry("TempMemberToken");
        }

        /**
         * Description is an HTMLText field filled from a plain textarea, so strip everything
         * the CMS editor would not allow (scripts, event handlers, ...)
         */
        protected function sanitiseProfileHtml($myMember) {
            $htmlValue = HTMLValue::create((string) $myMember->Description);
            HTMLEditorSanitiser::create(HTMLEditorConfig::get('cms'))->sanitise($htmlValue);
            $myMember->Description = $htmlValue->getContent();
        }

        public function finishEditingProfile() {
            $config = SiteConfig::current_site_config();

            $myData = [
                'ProfileForm' => DBField::create_field("HTMLText", $config->RegEditAfterText),
                'Content' => $config->RegEditAfterText
            ];

            return $myData;
        }

        public function changePasswordMode() {
            if ($this->getRequest()->getVar("changePassword") == "1" || $this->getRequest()->postVar("changePassword") == "1") {
                return true;
            } else {
                return false;
            }
        }

        public function PasswordChangeForm() {

            if ($myMember = $this->getCurrentMember()) {
            } else {
                return null;
            }
            //getMemberPasswordField
            $fields = FieldList::create(
                $passField = ConfirmedPasswordField::create('Password', 'Passwort*', null, null, false, 'Passwort bestätigen*')->setRequireExistingPassword(true)->setDescription("Das Passwort muss mindestens 8 Zeichen lang sein."),
                HiddenField::create("ID")->setValue($myMember->ID),
                HiddenField::create('changePassword', 'changePassword', '1')
                    //->setAttribute("placeholder", "z.B. 12345678")
            );

            $actions = FieldList::create(
                FormAction::create('submitPasswordChangeForm', _t("ProfileForm.Change",'Passwort ändern'))->addExtraClass("btn btn-dark rounded-pill w-100 btn-lg mt-3")
            );

            $validator = RequiredFieldsValidator::create('Password');

            $form = Form::create($this, __FUNCTION__, $fields, $actions, $validator); 

            return $form;
        }

        public function submitPasswordChangeForm($data, $form) {
            if ($myMember = $this->getCurrentMember()) { 
                if ($myMember->ID == $data["ID"]) {
                    $form->saveInto($myMember);
                    $myMember->write();

                    $myData = [
                        'PasswordChangeForm' => DBField::create_field("HTMLText", "<p>Dein Passwort wurde erfolgreich geändert.</p>"),
                        'Content' => "<p>Dein Passwort wurde erfolgreich geändert.</p>"
                    ];

                    return $myData;
                }
            } else {
                return null;
            }
        }
        
    }
}
