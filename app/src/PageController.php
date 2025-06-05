<?php

namespace {

use SilverStripe\Security\Security;

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\View\SSViewer;
    use SilverStripe\Security\Member;
    use SilverStripe\Security\Group;
    use SilverStripe\ORM\PaginatedList;
    use SilverStripe\Assets\Image;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;
    use SilverStripe\Blog\Model\BlogPost;

    class PageController extends ContentController
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
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();
            // You can include any CSS or JS required by your project here.
            // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/


            if ($this->URLSegment != "Security") {
                $myThemes = SSViewer::get_themes();
                $myThemePath = "themes/".$myThemes[1]."/";

                Requirements::css($myThemePath.'css/scss/bootstrap.scss');

                Requirements::css($myThemePath.'css/editor.scss');

                Requirements::backend()->setWriteHeaderComment(false);
                $css = [];

                // animate on scroll plugin
                //$css[] = $myThemePath.'css/aos.css';

                // custom fonts
                $css[] = $myThemePath.'css/fonts.css';

                // hamburger menu
                $css[] = $myThemePath.'css/hamburgers.min.css';

                // fancybox (uncomment js to)
                //$css[] = $myThemePath.'css/jquery.fancybox.min.css';

                $css[] = $myThemePath.'css/layout.css';
                $css[] = $myThemePath.'css/navigation.css';

                Requirements::combine_files('styles.css', $css);
                Requirements::process_combined_files();

                $js = [];
                $js[] = $myThemePath.'javascript/empty.js';
                Requirements::combine_files('jquery.js', $js, ["defer" => true]);
                Requirements::process_combined_files();

                $js = [];
                
                $js[] = $myThemePath.'javascript/jquery-3.6.0.min.js';
                $js[] = $myThemePath.'javascript/bootstrap.bundle.min.js';
                
                // animate on scroll plugin
                //$js[] = $myThemePath.'javascript/aos.js';
                
                // fancybox (uncomment css to)
                //$js[] = $myThemePath.'javascript/jquery.fancybox.min.js';

                $js[] = $myThemePath.'javascript/script.js';
                Requirements::combine_files('javascripts.js', $js, ["defer" => true]);
                Requirements::process_combined_files();

                $myAction = $this->getRequest()->param("Action");
                if ($myAction == "details") {
                    $js = [];
                    $js[] = $myThemePath.'javascript/particles.min.js';
                    
                    $js[] = $myThemePath.'javascript/particles-cfg.js';
                    Requirements::combine_files('particles.js', $js, ["defer" => true]);
                    Requirements::process_combined_files();
                }
            }
        }

        public function getCurrentMember() {
            $currentMember = Security::getCurrentUser();
            if ($currentMember) {
                return $currentMember;
            } else {
                return false;
            }
        }

        public function getMyClass($myClass = "Page") {
            return $myClass::get();
        }

        public function getBlogPost() {
            return BlogPost::get();
        }

        public function getMyMembers($paginated = true) {
            $myGroupMembers = Group::get()->byId(3)->Members()->exclude("New", "1")->exclude("Deactivated", "1");

            if ($paginated) {
                $myPagination = PaginatedList::create($myGroupMembers, $this->getRequest());
                $myPagination->setPageLength(12);

                return $myPagination;
            } else {
                return $myGroupMembers;
            }
            
        }

        public function getRandomVideo() {
            $videos = [];
    
            if ($this->Video1()->exists()) {
                $videos[] = $this->Video1()->Link();
            }
    
            if ($this->Video2()->exists()) {
                $videos[] = $this->Video2()->Link();
            }
    
            if ($this->Video3()->exists()) {
                $videos[] = $this->Video3()->Link();
            }
            return count($videos);
            if (count($videos) > 0) {
                return $videos[array_rand($videos)];
            }
        }

        public function getAllMemberRegions() {
            //$myRegions = explode(",", 'Amstetten,Baden,Bruck a.d. Leitha,Gänserndorf,Gmünd,Hollabrunn,Horn,Korneuburg,Krems Land,Krems Stadt,Lilienfeld,Melk,Mistelbach,Mödling,Neunkirchen,Scheibbs,Sankt Pölten Land,Sankt Pölten Stadt,Tulln,Waidhofen a.d. Thaya,Waidhofen a.d. Ybbs,Wiener Neustadt Land,Wiener Neustadt Stadt,Zwettl,Kein Bezirk');
            //return $myRegions;
            // regions from member enum
            $myRegions = Member::singleton()->dbObject('Region')->enumValues();
            $myRegions = array_filter($myRegions, function($region) {
                return $region !== 'Kein Bezirk';
            });

            return $myRegions;
        }

        
    }
}
