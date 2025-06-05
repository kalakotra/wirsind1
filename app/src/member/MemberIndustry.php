<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

class MemberIndustry extends DataObject {

	private static $default_sort = "Title";

	private static $db = [
		'Title' => 'Varchar(100)'
	];

}
