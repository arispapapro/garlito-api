<?php

namespace App\Helpers;

use App\Configuration\GarlitoApiConfiguration;
use App\Models\Language;

class GarlitoLanguageHelper
{
    public static function get_default_language(): Language | null {
        // Search if default language exists.
        return Language::where('code', GarlitoApiConfiguration::DEFAULT_USER_LANGUAGE_CODE)->first();
    }

}
