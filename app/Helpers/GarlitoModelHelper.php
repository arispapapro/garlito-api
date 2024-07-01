<?php

namespace App\Helpers;

// Utilities
use Illuminate\Support\Collection;

class GarlitoModelHelper
{

    public static function get_model_options(Collection $models, string $label_key, string $value_key): array
    {
        // Init Options
        $options = [];

        foreach($models as $model){

            // Turn Current Model Into Array
            $current_model = get_object_vars($model);

            $options[] = [
                'label' => $current_model[$label_key],
                'value' => $current_model[$value_key]
            ];
        }

        return $options;
    }
}
