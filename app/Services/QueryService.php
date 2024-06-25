<?php

namespace App\Services;

abstract class QueryService
{
    public function firstData($model, $data)
    {
        return $model::where($data)->first();
    }
}