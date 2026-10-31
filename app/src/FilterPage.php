<?php

namespace {

	use SilverStripe\Forms\CheckboxField;
	use SilverStripe\Forms\TextField;
	use SilverStripe\Forms\TextareaField;
	use SilverStripe\Forms\GridField\GridField;
	use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
	use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

	class FilterPage extends Page {

		private static $db = [
			'Subtitle' => 'Text'
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

			$fields->addFieldToTab("Root.Main", TextareaField::create("Subtitle"), "Content");

			$fields->removeFieldFromTab("Root.Main", "Content");
			    
			return $fields; 
		}

	}
}
