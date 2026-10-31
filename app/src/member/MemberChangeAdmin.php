<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class MemberChangeAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-edit-list';

	private static $managed_models = [
		MemberChange::class,
	]; 
	private static $url_segment = 'member-changes'; 
	private static $menu_title = "Profile Log";

	//private static $showImportForm = false;
	
}