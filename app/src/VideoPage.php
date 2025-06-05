<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class VideoPage extends Page {
    private static $db = [
        'TerminLink' => 'Varchar',
        'TextAfterTerminLink' => 'HTMLText',

        'Video1Title' => 'Varchar',

        'PreviewTitle' => 'Varchar',
        'PreviewText' => 'HTMLText',

        'WidgetTitle' => 'Varchar',
        'WidgetText' => 'Text',
    ];

    private static $has_one = [
        'Video1' => File::class,
        'Video2' => File::class,
        'Video3' => File::class,

        'Poster1' => Image::class,
        'Poster2' => Image::class,
        'Poster3' => Image::class,

        'HeaderImage' => Image::class,
    ];

    private static $owns = [
        'Video1',
        'Video2',
        'Video3',

        'Poster1',
        'Poster2',
        'Poster3',

        'HeaderImage',
    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', TextField::create('TerminLink', 'Termin Link'));
        $fields->addFieldToTab('Root.Main', HTMLEditorField::create('TextAfterTerminLink', 'Text After Termin Link')->addExtraClass('stacked'));
        $fields->addFieldToTab('Root.Header', UploadField::create('HeaderImage', 'Header Image'));

        $fields->addFieldToTab('Root.Preview', TextField::create('PreviewTitle', 'Preview Title'));
        $fields->addFieldToTab('Root.Preview', HTMLEditorField::create('PreviewText', 'Preview Text'));

        $fields->addFieldToTab('Root.Video', TextField::create('Video1Title', 'Video Title'));
        $fields->addFieldToTab('Root.Video', UploadField::create('Video1', 'Video 1'));
        $fields->addFieldToTab('Root.Video', UploadField::create('Poster1', 'Poster 1'));

        $fields->addFieldToTab('Root.Video', UploadField::create('Video2', 'Video 2'));
        $fields->addFieldToTab('Root.Video', UploadField::create('Poster2', 'Poster 2'));
        $fields->addFieldToTab('Root.Video', UploadField::create('Video3', 'Video 3'));
        $fields->addFieldToTab('Root.Video', UploadField::create('Poster3', 'Poster 3'));

        $fields->addFieldToTab('Root.Widget', TextField::create('WidgetTitle', 'Widget Title'));
        $fields->addFieldToTab('Root.Widget', TextareaField::create('WidgetText', 'Widget Text'));

        return $fields;
    }

    public function getRandomVideo() {
        $videos = [];
        $posters = [];

        if ($this->Video1()->exists()) {
            $videos[] = $this->Video1()->Link();

            if ($this->Poster1()->exists()) {
                $posters[] = $this->Poster1()->FocusFill(365,648)->Link();
            }
        }

        if ($this->Video2()->exists()) {
            $videos[] = $this->Video2()->Link();

            if ($this->Poster2()->exists()) {
                $posters[] = $this->Poster2()->FocusFill(365,648)->Link();
            }
        }

        if ($this->Video3()->exists()) {
            $videos[] = $this->Video3()->Link();

            if ($this->Poster3()->exists()) {
                $posters[] = $this->Poster3()->FocusFill(365,648)->Link();
            }
        }
        
        if (count($videos) > 0) {
            $myRand = rand(0, count($videos) - 1);
            $myData = [
                'video' => $videos[$myRand],
            ];

            if (count($posters) > 0) {
                $myData['poster'] = $posters[$myRand];
            }
            return $this->customise($myData);
        }
    }
}
