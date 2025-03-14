<?php

use Panakour\FilamentFlatPage\Facades\FilamentFlatPage;

if (! function_exists('general_settings')) {
    function general_settings($key)
    {
        return FilamentFlatPage::get('general_settings.json', $key);
    }
}

if (! function_exists('localizedUrl')) {
    function localizedUrl($path = '')
    {
        return url(app()->getLocale() . '/' . ltrim($path, '/'));
    }
}
