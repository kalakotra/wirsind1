<?php

namespace {

	use SilverStripe\Forms\CheckboxField;
	use SilverStripe\Forms\TextField;
	use SilverStripe\Forms\GridField\GridField;
	use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
	use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

	class FormularPage extends FilterPage {

		private static $db = [
		];

		private static $has_one = [];

		private static $has_many = [
			
		];

		public function getCMSFields() { 
			$fields = parent::getCMSFields();

			$fields->removeFieldFromTab("Root.Main", "Content");
			    
			return $fields; 
		}

	}
}
