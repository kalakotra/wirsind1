<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;
use SilverStripe\Forms\Form;
use SilverStripe\Security\Group;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;

class ExportPageController extends PageController {

	private static $allowed_actions = [
        'Form'
    ];

	public function init() {
		parent::init();

		// the export contains personal data of all members - admins only
		// (CMS setting "logged-in users" would allow every registered member)
		if (!$this->getResponse()->isFinished() && !Permission::check('ADMIN')) {
			Security::permissionFailure($this);
			return;
		}
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}

	public function Form() {
        

        $my_fields = $this->myFieldsArray();

        $options = array_combine(array_keys($my_fields), array_keys($my_fields));

        
        $myFields = new FieldList(
            CheckboxSetField::create("ExportFields", "Export fields", $my_fields),
            DropdownField::create('Newsletter', 'Newsletter', array('0' => 'Ja', '1' => 'Nein'))->setEmptyString("Alle")->addExtraClass("mb-3"),
            DropdownField::create("Status", "Status", [
                'New' => 'Neu',
                'Deactivated' => 'Deaktiviert'
            ])->setEmptyString("Aktiv")->addExtraClass("mb-3")
            /*,
            LiteralField::create("separator", "<hr>"),
            DropdownField::create("FilterCompetition", "Filter by Competition", Competition::get()->map())->setEmptyString('All'),
            DropdownField::create("FilterKategorie", "Filter by category", Kategorie::get()->map())->setEmptyString('All'),
            DropdownField::create("FilterStatus", "Filter by status", array("0"=>"All", "geprüft&freigegeben"=>"geprüft&freigegeben", "in Bearbeitung"=>"in Bearbeitung", "nicht zugelassen"=>"nicht zugelassen", "neu"=>"neu")),
            DropdownField::create("FilterNominierte", "Filter by Nominierte", array("0"=>"All", "Ja"=>"Ja", "Nein"=>"Nein"))*/
        );

        $myReqFields = new RequiredFieldsValidator();
        
        
        $actions = new FieldList( 
            new FormAction('exportDoc', 'Export CSV') 
        ); 
        return new Form($this, 'Form', $myFields, $actions, $myReqFields);

        //print_r(Project::$db);

        

    }


    public function exportDoc($data, $form) {
        $separator = ";";
        $what = array("–", /*"Ü", "ü", "Ö", "ö", "Ä", "ä", "ß",*/ ";", "
            ", "
", "\r\n", "\n\r", "\n", "\r");
        $with = array("-", /*"UE", "ue", "OE", "oe", "AE", "ae", "ss",*/ " ", " ", " ", " ", " ", " ", " ");

        //$myMembers = $this->getMyMembers(false)->sort("Created DESC");
        $myMembers = Group::get()->byId(3)->Members()->sort("Created DESC");

        $fileData = '';
        $newData = [];

        if (isset($data["ExportFields"])) {

            if (isset($data["Newsletter"]) && $data["Newsletter"] != "") {
                $myMembers = $myMembers->filter("NoNewsletter", $data["Newsletter"]);
            }

            foreach ($data["ExportFields"] as $key => $value) {
                $fileData .= $this->switchTitle($value).$separator;
            }

            /* add status to export */
            //$fileData .= "Status".$separator;
            $fileData .= "\n";

            // generate status values
            if ($data["Status"] == "New") {
                $status = 'Neu';
            } else if ($data["Status"] == "Deactivated") {
                $status = 'Deactivated';
            } else {
                $status = 'Veröffentlicht';
            }

            foreach ($myMembers as $pKey => $pValue) {
                if ($pValue->myNew() == $status) {
                    $lineArray = [];
                    foreach ($data["ExportFields"] as $key => $value) {
                        //$fileData .= str_replace($what, $with, strip_tags($pValue->$value)).$separator;
                        //$lineArray[$value] = str_replace($what, $with, strip_tags($pValue->$value));
                        if ($key == 'MemberIndustry.Title') {
                            $fileData .= $pValue->MemberIndustry()->Title.$separator;
                            $lineArray['Branche'] = $pValue->MemberIndustry()->Title;
                        } else {
                            $fileData .= str_replace($what, $with, strip_tags($pValue->$value)).$separator;
                            $lineArray[$value] = str_replace($what, $with, strip_tags($pValue->$value));
                        }
                    }

                    //$fileData .= $pValue->myNew().$separator;
                    $fileData .= "\n";
                    $newData[] = $lineArray;
                } 
                
            }
        }
        
        

        $now = Date("d-m-Y-H-i");
        $fileName = "export-$now.xls";
        $this->getResponse()->addHeader('Content-Encoding', 'charset=UTF-8');
        /*$fileData = chr(255) . chr(254) . mb_convert_encoding( $fileData, 'UTF-16LE', 'UTF-8');
        return HTTPRequest::send_file($fileData, $fileName, 'application/csv');*/

        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        header("Content-Type: application/vnd.ms-excel; charset=UTF-16LE");

        $flag = false;
        $myData = "";
        foreach($newData as $row) { 
            if(!$flag) { 
                // display column names as first row 
                echo implode("\t", array_keys($row)) . "\n"; 
                $flag = true; 
            } 
            // filter data 
            array_walk($row, [$this, 'filterData']); 
            $myData .= implode("\t", array_values($row)) . "\n"; 
        } 
        echo mb_convert_encoding( $myData, 'UTF-16LE', 'UTF-8');

        exit;
        //$this->redirectBack();
    }

    public function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }

    public function switchTitle($myKey) {
        $my_fields = $this->myFieldsArray();

        return $my_fields[$myKey];
    }

    public function myFieldsArray() {
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
