<?php

namespace {

	use SilverStripe\Forms\CheckboxField;
	use SilverStripe\Forms\DropdownField;
	use SilverStripe\Forms\TextField;
	use SilverStripe\Forms\TextareaField;
	use SilverStripe\Forms\GridField\GridField;
	use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
	use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

	class HomePage extends Page {

		private static $db = [
			'ProfilesTitle' => 'Varchar',
			'ProfilesText' => 'Text',
			'ProfilesLinkTitle' => 'Varchar',
			'ProfilesLinkURL' => 'Varchar',

			'BlogTitle' => 'Varchar',
			'BlogText' => 'Text'
		];

		private static $has_one = [];

		private static $has_many = [
			'HomeSlide' => HomeSlide::class
		];

		public function getCMSFields() { 
			$fields = parent::getCMSFields();

			$fields->removeByName([
				'HeaderSubtitle',
				'Custom'
			]);

			$config = GridFieldConfig_RecordEditor::create();
			$config->addComponent(GridFieldOrderableRows::create("Sort"));
			$gridField = new GridField('HomeSlide', 'HomeSlide', $this->HomeSlide(), $config);
			$fields->addFieldToTab("Root.Slider", $gridField);

			$fields->addFieldsToTab("Root.Profiles", [
				TextField::create("ProfilesTitle", "Title"),
				TextareaField::create("ProfilesText", "Text"),
				TextField::create("ProfilesLinkTitle", "Link Title"),
				TextField::create("ProfilesLinkURL", "Link URL")
			]);
			    
			$fields->addFieldsToTab("Root.Blog", [
				TextField::create("BlogTitle", "Title"),
				TextareaField::create("BlogText", "Text")
			]);
			    
			return $fields; 
		}

	}
}
