<?php

namespace App\Helpers;

class GarlitoResourceHelper
{

    public static function get_id_timestamps(Object $model): array
    {
        if(isset($model->id) && isset($model->created_at) && isset($model->updated_at))
            return [ 'id' => $model->id , 'created_at' => $model->created_at , 'updated_at' => $model->updated_at ];
        return [];
    }
}
