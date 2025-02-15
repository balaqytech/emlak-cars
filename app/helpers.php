<?php

use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

if (! function_exists('general_settings')) {
    function general_settings($key)
    {
        return FilamentFlatPage::get('general_settings.json', $key);
    }
}
