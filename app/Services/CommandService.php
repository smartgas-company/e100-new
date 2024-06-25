<?php

namespace App\Services;

abstract class CommandService
{
    public function updateAllData($model, $data): void
    {
        $model::update($data);
    }

    public function createData($model, $data)
    {
        return $model::create($data);
    }

    public function update($model, $data)
    {
        foreach ($data as $key => $value)
        {
            $model->{$key} = $value;
        }
        $model->save();
        return $model;
    }
}