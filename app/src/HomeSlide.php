<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Group;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\AssetAdmin\Forms\UploadField;


class HomeSlide extends DataObject {

	private static $default_sort = "Sort";

	private static $db = [
		'Inactive' => 'Boolean',
		'Title' => 'Varchar(100)',
		'SlideTime' => 'Int',
		'Sort' => 'Int'
	];

	private static $has_one = [
		'HomePage' => HomePage::class,
		'Image' => Image::class,
		'MobileImage' => Image::class,
		'Page' => Page::class,
		'Profile' => Member::class,
		'VideoDesktop' => File::class,
		'VideoMobile' => File::class
	];

	private static $owns = [
		'Image',
		'MobileImage',
		'VideoDesktop',
		'VideoMobile'
	];

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab("Root.Main", "Sort");

		$fields->addFieldToTab("Root.Main", TreeDropdownField::create("PageID", _t("SliderImage.SITETREE", "Link"), SiteTree::class));
		$myGroupMembers = Group::get()->byId(3)->Members()->map();
		$fields->addFieldToTab("Root.Main", DropdownField::create("ProfileID", _t("SliderImage.Profile", "Profile"), $myGroupMembers)->setEmptyString("---"));
		$fields->addFieldsToTab("Root.Main", 
			[
				$myUpload = UploadField::create("Image"),
				$myUploadSmall = UploadField::create("MobileImage")
			]
		);
		$myUpload->setFolderName("/Uploads/Slider/");
		$myUploadSmall->setFolderName("/Uploads/Slider/");

		$fields->addFieldsToTab("Root.Main", 
			[
				$myUploadVideo = UploadField::create("VideoDesktop"),
				$myUploadVideoSmall = UploadField::create("VideoMobile")
			]
		);
		$myUploadVideo->setFolderName("/Uploads/Slider/");
		$myUploadVideoSmall->setFolderName("/Uploads/Slider/");

		return $fields;
	}

	public function convertedSlideTime() {
		if ($this->SlideTime == 0) {
			return false;
		} else {
			return $this->SlideTime*1000;
		}
	}

}
