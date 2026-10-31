<?php

use SilverStripe\i18n\i18n;
use SilverStripe\TinyMCE\TinyMCEConfig;

// Password rules (min. 8 characters) are configured in _config/passwords.yml

i18n::set_locale('de_AT'); // Setting the locale to German (Germany)

// TinyMCE 6: the former "styleselect" button is called "styles"
TinyMCEConfig::get('cms')
    ->addButtonsToLine(1, 'styles')
    ->setOption('importcss_append', true);

TinyMCEConfig::get('cms')->setOption('extended_valid_elements',
    'audio[controls],source[src|type]'
);
