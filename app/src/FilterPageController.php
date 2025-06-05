<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Security\Security;
    use SilverStripe\View\Requirements;
    use SilverStripe\View\SSViewer;
    use SilverStripe\Security\Member;
    use SilverStripe\Security\Group;
    use SilverStripe\ORM\PaginatedList;
    use SilverStripe\Assets\Image;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;

    class FilterPageController extends PageController
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
            'details' 
        ];

        public function init() {
            parent::init();
            $myMemberID = $this->getRequest()->param("Action");
            if (is_numeric($myMemberID)) {
                $myGroupMembers = Group::get()->byId(3)->Members()->filter(["OldId"=>$myMemberID]);
                if ( $myGroupMembers->exists() ) {
                    $this->redirect($this->Link("details/".$myGroupMembers->First()->ID));
                }

            }
        }

        public function getCurrentUser() {
            if( $member = Security::getCurrentUser() ) {
                return $member;
            } else {
                return false;
            }
        }

        public function details($request)
        {
            
            $myMemberID = $this->getRequest()->param("ID");
            $myMember = Member::get()->byId($myMemberID);

            //return $myMember->renderWith("ProfilePage", "Page");
            if($this->getCurrentUser() && $this->getCurrentUser()->inGroup(2)) {

            } else {
                if ($myMember->New == 1 || $myMember->Deactivated == 1) {
                    $this->redirect($this->Link());
                }
            }

            return $this->customise($myMember)->renderWith("Page");
        }

        public function getMemberRegions() {
            //$myEnums = Member::get()->dbObject('Region')->enumValues();
            $myEnums = $this->getAllMemberRegions();
            $list = ArrayList::create();

            foreach ($myEnums as $myEnum) {
                $list->push(new ArrayData(array('Region' => $myEnum)));
            }
            return $list;
        }

        public function getBackLinkMembers() {
            // check get variable "paged"
            if (isset($_GET["paged"])) {
                $myGroupMembers = Group::get()->byId(3)->Members()->exclude("New", "1")->exclude("Deactivated", "1")->sort("Created DESC");

                if (isset($_GET["ind"])) {
                    $myGroupMembers = $myGroupMembers->filter("MemberIndustryID",$_GET["ind"]);
                }

                if (isset($_GET["bz"])) {
                    $myGroupMembers = $myGroupMembers->filter("Region",$_GET["bz"]);
                }

                if (isset($_GET["tx"])) {
                    $myGroupMembers = $myGroupMembers->filterAny([
                        'FirstName:PartialMatch' => $_GET["tx"],
                        'Surname:PartialMatch' => $_GET["tx"],
                        'CompanyName:PartialMatch' => $_GET["tx"],
                        'Description:PartialMatch' => $_GET["tx"],
                        'Text:PartialMatch' => $_GET["tx"]
                    ]);
                }

                // limit to "start" + 12
                if (isset($_GET["start"])) {
                    $myLimit = $_GET["start"] + 12;
                } else {
                    $myLimit = 12;
                }

                return $myGroupMembers->limit($myLimit);
            } else {
                return false;
            }
        }

        public function getMyMembers($paginated = true) {



            $myGroupMembers = Group::get()->byId(3)->Members()->exclude("New", "1")->exclude("Deactivated", "1")->sort("Created DESC");

            if (isset($_GET["ind"])) {
                $myGroupMembers = $myGroupMembers->filter("MemberIndustryID",$_GET["ind"]);
            }

            if (isset($_GET["bz"])) {
                $myGroupMembers = $myGroupMembers->filter("Region",$_GET["bz"]);
            }

            if (isset($_GET["tx"])) {
                $myGroupMembers = $myGroupMembers->filterAny([
                    'FirstName:PartialMatch' => $_GET["tx"],
                    'Surname:PartialMatch' => $_GET["tx"],
                    'CompanyName:PartialMatch' => $_GET["tx"],
                    'Description:PartialMatch' => $_GET["tx"],
                    'Text:PartialMatch' => $_GET["tx"]
                ]);
            }
            
            $myPagination = PaginatedList::create($myGroupMembers, $this->getRequest());
            $myPagination->setPageLength(12);

            return $myPagination;

            //foreach ($myGroupMembers as $key => $value) {
                
                /* update images */
                /*if ($value->OldImageId > 0) {
                    $myImage = Image::get()->filter(["Name" => $value->OldImageId.".jpg"]);
                    if ( $myImage->exists() ) {
                        $myImage = $myImage->First();
                        $value->ImageID = $myImage->ID;
                        $value->write();
                        echo $value->Name."<br />";
                        echo $value->Image()->ID."<br />";
                        
                        //echo 'UPDATE Member SET ImageID='.$myImage.' WHERE ID='.$this->owner."<-- <br />";
                        //DB::query('UPDATE Member SET ImageID='.$myImage->ID.' WHERE ID='.$this->owner->ID);
                        //return $myImage;
                    }
                } */

                /* Update Groups */
                /* $value->Groups()->add($myGroup);*/

                /* Update Industry */
                /*$myIndustry = MemberIndustry::get()->filter(["Title" => $value->OldIndustry]);
                if ($myIndustry->exists()) {
                    echo $myIndustry->First()->Title."<br />";

                    $value->MemberIndustryID = $myIndustry->First()->ID;
                }*/

                
                /* Update Texts */
                /*$obj = json_decode($value->OldText, true);

                echo $obj["text"]."<br /><br />";
                $value->Text = $obj["text"];
                $value->Description = $obj["description"];*/

                //$value->write();
            //}


            //return $myGroupMembers;
        }
    }
}
