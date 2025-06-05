<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class CustomMemberAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-edit-list';

	private static $managed_models = [
		'profiles' => [
            'dataClass' => Member::class,
            'title' => 'All'
        ],
        'export-profiles' => [
            'dataClass' => Member::class,
            'title' => 'Export'
        ]
	]; 
	private static $url_segment = 'profiles'; 
	private static $menu_title = "Profiles";

	//private static $showImportForm = false;
	public function getList()
    {
        //$list =  parent::getList();
        
        $myGroup = Group::get()->byId(3);
        if ($this->modelTab === 'profiles') {
        	$list = $myGroup->Members(); //->filter(["New"=>"1"]);
        } else {
        	$list = $myGroup->Members()->exclude(["New"=>"1"]);
        }
        
        $list = $list->sort("New DESC, Created DESC");
        return $list;
    }

    public function getExportFields() 
    {
        return [
            'FirstName' => 'Vorname',
            'Surname' => 'Nachname',
            'CompanyName' => 'Firmenname',
            'Email' => 'E-Mail',
            'MemberIndustry.Title' => 'Branche',
            'PostCode' => 'PLZ',
            'Region' => 'Bezirk',
            'Created' => 'Datum des Eintrags'
        ];
    }
	
}