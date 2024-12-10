<?php

namespace Database\Seeders;

use App\Constants\GarlitoConstants;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = GarlitoConstants::ALL_LANGUAGES;

        foreach($languages as $language){
            Language::create($language);
        }
    }
}
