<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Forms\LiteralField;

class MemberChange extends DataObject {

	private static $default_sort = "Created DESC";

	private static $db = [
        //'Title' => 'Varchar',
		'ChangedFieldsText' => 'Text',
        'InCMS' => 'Boolean'
	];

    private static $has_one = [
        'Member' => Member::class,
        'ChangedFrom' => Member::class
    ];

    private static $summary_fields = [
        'Created' => 'Created',
        'Member.Title' => 'Member',
        'ChangedFrom.Title' => 'Changed From',
        'ChangedFieldsText' => 'Changed Fields',
        'InCMS' => 'In CMS'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        

        return $fields;
    }

    public function getChangedFieldsAsText() {
        // if array convert to text
        if (is_array($this->ChangedFields)) {
            return implode(", ", array_keys($this->ChangedFields));
        } else {
            return (string)$this->ChangedFields;
        }
    }

}
