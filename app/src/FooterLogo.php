<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

class FooterLogo extends DataObject {

	private static $default_sort = "Sort"; 

	private static $db = [
		'Text' => 'Text',
		'Sort' => 'Int'
	];

	private static $has_one = [
		'Logo' => Image::class
	];

	private static $owns = [
		'Logo'
	];


	public function getCMSFields() {
	  	$fields = parent::getCMSFields();
	  	
	  	$fields->addFieldToTab("Root.Main", $myUplaod = UploadField::create("Logo"));

        $myUplaod->setFolderName("Uploads/Footer-Logo");

	  	return $fields;
	}

	private static $summary_fields = array(
		'getThumbnail' => 'Logo',
		'Text' => 'Text'
	);

	public function getThumbnail() { 
		return $this->Logo()->CMSThumbnail(); 
	}

}
